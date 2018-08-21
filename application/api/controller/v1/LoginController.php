<?php
/**
 * Created by PhpStorm.
 * User: 76871
 * Date: 2018/8/13
 * Time: 15:52
 */
namespace app\api\controller\v1;

use app\api\controller\CommonController;
use app\common\lib\Aes;
use app\common\lib\IAuth;
use app\common\model\User;
use think\Exception;

class LoginController extends CommonController
{
    /**
     * 登录
     * @return \json|\think\response\Json
     */
    public function save()
    {
        if (!request()->isPost()) {
            return apiReturn(config('code.app_show_error'), '您没有权限', '', 403);
        }

        $param = input('param.');
        // validate
        $validate = validate('Login');
        if (!$validate->check($param, 'Login.save')) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
        }

        $bool = $this->checkLoginVerify($param['verify'], $param['sno'], $param['cardno']);
        if (false == $bool) {
            return apiReturn(config('code.app_show_error'), '非法请求', '', 400);
        }

        //获得token
        $token = IAuth::setAppLoginToken($param['cardno']);
        //查询数据库cardno是否存在
        $user = User::get(['cardno' => $param['cardno']]);
        if (!$user) {
            //第一次登录，注册信息
            $data = [
                'token' => $token,
                'time_out' => strtotime("+" . config('app.login_time_out_day') . " days"),
                'nickname' => '小Q'.$param['cardno'],
                'realname' => $param['realname'],
                'sex' => $param['sex'],
                'college' => $param['college'],
                'last_login_time' => time(),
                'status' => 1,
            ];
            try {
                $id = model('User')->add($data);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }

        } else {
            //非第一次登录，更新过期时间和token
            $data = [
                'token' => $token,
                'time_out' => strtotime("+" . config('app.login_time_out_day') . " days"),
            ];
            try {
                $info = model('User')->save($data, ['id' => $user['id']]);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }

        }

        $obj = new Aes();
        if ($id || $info) {
            $result = [
                //token加密后传输给客户端
                'token' => $obj->encrypt($token . "||" . $id . "||" . time()),
            ];

            return apiReturn(config('code.app_show_success'), '登录成功', $result, 200);
        } else {
            return apiReturn(config('code.app_show_error'), '登录失败', '', 500);
        }
    }

    /**
     * 验证登录信息
     * @param string $verify
     * @param string $sno
     * @param string $cardno
     * @return bool
     */
    private function checkLoginVerify($verify = '', $sno = '', $cardno = '')
    {
        $verify = base64_decode($verify);
        $verifications = explode("||", $verify);
        $aes = new Aes();
        //使用aes解密
        $verifications[1] = $aes->decrypt($verifications[1]);
        if ($cardno == $verifications[0] && $sno == $verifications[1]) {
            return true;
        } else {
            return false;
        }
    }
}