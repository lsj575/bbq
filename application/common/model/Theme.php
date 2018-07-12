<?php
namespace app\common\model;

use think\Model;
class Theme extends Base
{
    /**
     * 查询主题 后台自动分页
     * @param array $data
     * @return \think\Paginator
     */
    public function getTheme($data = [])
    {
        $data['status'] = [
            'neq', config('code.status_delete')
        ];

        $order = ['id' => 'desc'];

        // 查询
        $result = $this->where($data)
            ->order($order)
            ->paginate();

        return $result;
    }
}