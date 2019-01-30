<?php
namespace app\common\model;

use think\Model;

class AdminRole extends Base{
    protected $table = 'admin_role';

    //判断某个管理用户对特定控制器下的特定行为是否有权限
    public function havePermission($admin_id , $controller, $action){
        $roleid = model('AdminUser')::get($admin_id)->roleid;

        $powerid = model('AdminRole')::get($roleid)->powerid;
        $powerid = explode('|', $powerid);

        foreach ($powerid as $pid){
            $p = model('AdminPower')::get($pid);

            if($p->controller == $controller && $p->action == $action){
                return true;
            }
        }

        return false;

    }
}
