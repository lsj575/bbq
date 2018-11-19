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

    /**
     * 根据条件来获取列表的数据总数
     * @param array $condition
     * @return int|string
     */
    public function getCountByCondition($condition = [])
    {
        $condition['status'] = [
            'neq', config('code.status_delete'),
        ];

        return $this->where($condition)
            ->count();
    }
}