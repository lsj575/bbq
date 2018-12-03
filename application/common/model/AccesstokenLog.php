<?php
namespace app\common\model;

/**
 * 记录信息控制器
 * Class AppActive
 * @package app\common\model
 */
class AccesstokenLog extends Base
{
    protected $table = 'accesstoken_log';

    /**
     * 获取用户60秒内请求access_token的数量
     * @param $user_id
     * @return int|string
     */
    public function getRequestTime($user_id)
    {
        return $this->where(['user_id' => $user_id])
            ->where(['create_time' => ['>', time()-60]])
            ->count();
    }
}