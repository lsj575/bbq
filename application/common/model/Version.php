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
     * 通过app_type获取最后一条状态正常的版本内容
     * @param string $appType
     * @return false|\PDOStatement|string|\think\Collection
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