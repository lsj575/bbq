<?php
namespace app\common\model;

use think\Model;

class AdminPower extends Base{
    //添加一条行为
    public function add($data){
        if (!is_array($data))
            exception('传递数据不合法');

        $this->allowField(true)->save($data);

        return $this->powerid;
    }
}
