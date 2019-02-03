<?php
namespace app\admin\controller;

use think\Controller;

class IndexController extends  BaseController
{
    public function index()
    {
        return $this->fetch();
    }

    public function welcome()
    {
        $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));
        $user_data = [
            'username'          =>  $user->username,
            'last_login_ip'     =>  $user->last_login_ip,
            'last_login_time'   =>  date("Y-m-d h:i:sa",$user->last_login_time),
        ];
        $bbq_info = [
            'user'      =>  count(model('User')->select()),
            'theme'     =>  count(model('Theme')->select()),
            'article'   =>  count(model('Article')->select()),
            'admin'     =>  count(model('AdminUser')->select()),
            'feedback'  =>  count(model('Feedback')->select())
        ];
        return $this->fetch('',[
            'user'  =>  $user_data,
            'info'  =>  $bbq_info
        ]);
    }
}
