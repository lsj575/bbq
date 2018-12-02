<?php
namespace app\common\model;

use think\Model;
class User extends Base
{
    protected $table = 'user';
    /**
     * 查询用户后台自动分页
     * @param array $data
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getUser($data = [])
    {
        $data['status'] = [
            'neq', config('code.user_delete')
        ];

        $order = ['id' => 'desc'];

        // 查询
        $result = $this->where($data)
            ->order($order)
            ->paginate();

        return $result;
    }
}