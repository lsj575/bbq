<?php
namespace app\api\controller\v1;

use app\common\lib\Aes;;

/**
 * 用户类，获取修改用户信息等功能
 * Class UserController
 * @package app\api\controller\v1
 */
class UserController extends AuthBaseController
{
    /**
     * 获取用户信息
     * user信息为其父类AuthBaseController获得
     * 用户基本信息较为隐私需要加密
     * @return \json|\think\response\Json
     */
    public function read()
    {
        $obj = new Aes();

        return apiReturn(config('code.app_show_success'), 'ok', $obj->encrypt($this->user));
    }

    /**
     * 更新用户信息
     * @return \json|\think\response\Json
     */
    public function update()
    {
        $postData = input('param.');

        // validate
        $validate = validate('User');
        if (!$validate->check($postData, [], 'User.update')) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
        }

        //严格判断要插入的数据
        $data = [];
        if (!empty($postData['avatar'])) {
            $data['avatar'] = $postData['avatar'];
        }
        if (!empty($postData['nickname'])) {
            $data['nickname'] = $postData['nickname'];
        }
        if (!empty($postData['signature'])) {
            $data['signature'] = $postData['signature'];
        }
        if (!empty($postData['home_img'])) {
            $data['home_img'] = $postData['home_img'];
        }

        if (empty($data)) {
            return apiReturn(config('code.app_show_error'), '数据不合法', [], 404);
        }

        try {
            $id = model('User')->save($data, ['id' => $this->user->id]);
            if ($id) {
                return apiReturn(config('code.app_show_success'), 'ok', [], 202);
            } else {
                return apiReturn(config('code.app_show_error'), '更新失败', [], 401);
            }
        } catch (\Exception $e) {
            return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
        }
    }

    /**
     * 检查昵称是否合法
     * 在用户选择保存对应数据前，若有填写昵称则访问此接口提前检查昵称合法性
     * @return \json|\think\response\Json
     */
    public function checkUserNicknamePass()
    {
        if (!request()->isGet()) {
            return apiReturn(config('code.app_show_error'), '您没有权限', '', 403);
        }

        $getData = input('get.');

        // validate
        $validate = validate('User');
        if (!$validate->check($getData, [], 'User.checkUserNicknamePass')) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
        }

        try {
            $count = model('User')->where(['nickname' => $getData['nickname']])->count();
        } catch (\Exception $e) {
            return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
        }


        if ($count) {
            return apiReturn(config('code.app_show_success'), '昵称符合要求', [], 202);
        } else {
            return apiReturn(config('code.app_show_error'), '昵称已存在', [], 401);
        }

    }
}