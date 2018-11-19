<?php
namespace app\admin\controller;

use app\common\lib\IAuth;

class LoginController extends BaseController
{
    public function _initialize()
    {

    }

    public function index()
    {
        //如果后台用户已经登录则跳转到后台首页
        $isLogin = $this->isLogin();
        if ($isLogin) {
            return $this->redirect('index/index');
        }else {
            return $this->fetch();
        }
        return $this->fetch();
    }

    /**
     * 登录相关业务
     */
    public function check()
    {
        if (request()->isPost()) {
            $data = input('post.');

            //暂时取消验证码
//            if (!captcha_check($data['code'])) {
//                $this->error('验证码不正确');
//            }
            //判定 username password
            //validate
            $validate = validate('AdminUser');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            try {
                //通过username查询用户
                $user = model('AdminUser')->get([
                    'username'    => $data['username'],
                ]);
            }catch (\Exception $e) {
                $this->error($e->getMessage());
            }

            if (!$user || $user->status != config('code.status_normal')) {
                $this->error('该用户不存在');
            }

            //再对密码进行校验
            if (IAuth::setPassword($data['password']) != $user['password']) {
                $this->error('密码不正确');
            }
            //更新数据库 登录时间 登陆ip
            $udata = [
                'last_login_time' => time(),
                'last_login_ip'   => request()->ip(),
            ];

            try {
                model('AdminUser')->save($udata, ['id' => $user->id]);
            }catch (\Exception $e) {
                $this->error($e->getMessage());
            }

            //session
            session(config('admin.session_user'), $user, config('admin.session_user_scope'));
            $this->success('登录成功', 'index/index');
        }else {
            $this->error('请求不合法');
        }
    }

    /**
     * 退出登录
     * 1 清空session
     * 2 跳转到登录
     */
    public function logout()
    {
        session(null, config('admin.session_user_scope'));
        $this->redirect('login/index');
    }
}
