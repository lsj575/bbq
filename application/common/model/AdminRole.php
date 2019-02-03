<?php
namespace app\common\model;

use think\Model;

class AdminRole extends Base{
    protected $table = 'admin_role';

    //判断某个管理用户对特定控制器下的特定行为是否有权限
    public function havePermission($controller, $action){
        $p = model('AdminPower')::where(['controller'=>['=',$controller],'action'=>['=',$action]])->field('powerid')->select();

        if($p && preg_match("/\|".$p[0]->powerid."\|/",session('powerid','',config('admin.session_user_scope'))))
            return true;

        return false;

    }
}
