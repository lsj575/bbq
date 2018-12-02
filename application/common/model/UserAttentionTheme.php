<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/21
 * Time: 11:05 AM
 */
namespace app\common\model;

/**
 * 用户关注主题模型
 */
class UserAttentionTheme extends Base
{
    protected $table = 'user_attention_theme';

    /**
     * 获取用户关注的主题
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getThemeOfUserAttention($id)
    {
        $whereData = [
            'uat.user_id'   => $id,
            't.status'      => config('code.status_normal'),
        ];

        return $this->table($this->table)
            ->alias('uat')
            ->join('theme t', 'uat.theme_id = t.id')
            ->where($whereData)
            ->order('uat.create_time desc')
            ->select();
    }

}