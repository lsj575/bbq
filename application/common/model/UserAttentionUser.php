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
class UserAttentionUser extends Base
{
    protected $table = 'user_attention_user';

    /**
     * 获取用户关注的用户
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserOfUserAttention($id)
    {
        $whereData = [
            'uau.attention_user_id' => $id,
            'u.status'              => config('code.status_normal'),
        ];

        return $this->table($this->table)
            ->alias('uau')
            ->join('user u', 'uau.be_attention_user_id = u.id')
            ->where($whereData)
            ->order('uau.create_time desc')
            ->select();
    }

    /**
     * 获取用户的粉丝（关注他的人）
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserOfUserBeAttention($id)
    {
        $whereData = [
            'uau.be_attention_user_id'  => $id,
            'u.status'                  => config('code.status_normal'),
        ];

        return $this->table($this->table)
            ->alias('uau')
            ->join('user u', 'uau.attention_user_id = u.id')
            ->where($whereData)
            ->order('uau.create_time desc')
            ->select();
    }
}