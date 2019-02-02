<?php
namespace app\common\model;

use think\Model;

class AdminUser extends Base
{
    public function getUser($data=[]) {
        $whereData = [];

        //按用户名查询
        if(!empty($data['username'])) {
            $whereData['username'] = ['like','%'.$data['username'].'%'];
        }


        $results = model('AdminUser')->where($whereData)->paginate(5)->each(function($item,$key) {
            $item->role_name = model('AdminRole')::get($item->roleid)->rolename;
        });

        return $results;
    }
}
