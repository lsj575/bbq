<?php
namespace app\admin\controller;

use think\Controller;

/**
 * Class BaseController
 * @package app\admin\controller
 * 基础类库
 */
class BaseController extends Controller
{
    /**
     * 初始化方法
     */
    public function _initialize()
    {
        $isLogin = $this->isLogin();
        if (!$isLogin) {
            return $this->redirect('login/index');
        }
    }

    /**
     * 判断是否登录
     * @return bool
     */
    public function isLogin()
    {
        //获取session
        $user = session(config('admin.session_user'), '',config('admin.session_user_scope'));
        if ($user && $user->id) {
            return true;
        }
        return false;
    }
}