<?php
namespace app\common\model;

/**
 * 版本控制器
 * Class Version
 * @package app\common\model
 */
class Version extends Base
{
    /**
     * 查询版本 后台自动分页
     * @param array $data
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getVersion($data = [])
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

    /**
     * 通过app_type获取最后一条状态正常的版本内容
     * @param string $appType
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getLastNormalVersionByAppType($appType = '')
    {
        $data = [
            'status'   => 1,
            'app_type' => $appType,
        ];

        //按更新时间排序
        $order = [
            'id' =>  'desc',
        ];

        return $this->where($data)
            ->order($order)
            ->limit(1)
            ->select();
    }
}