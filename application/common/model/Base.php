<?php
namespace app\common\model;

use think\Model;

class Base extends Model
{
    protected $autoWriteTimestamp = true;

    /**
     * @param mixed|string $data
     * @return mixed
     */
    public function add($data)
    {
        if (!is_array($data)) {
            exception('传递数据不合法');
        }
        $this->allowField(true)->save($data);

        return $this->id;
    }
}