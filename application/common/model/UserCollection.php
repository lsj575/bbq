<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/21
 * Time: 11:05 AM
 */
namespace app\common\model;

/**
 * 用户收藏模型
 */
class UserCollection extends Base
{
    protected $table = 'user_collection';

    /**
     * 获取用户收藏的动态
     * @param $user_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getArticleOfUserCollect($user_id)
    {
        $whereData = [
            'a.status'      => config('code.status_normal'),
            't.status'      => config('code.status_normal'),
            'uc.user_id'    => $user_id,
        ];

        return $this->table($this->table)
            ->alias('uc')
            ->field($this->_getListField())
            ->join('article a', 'a.id = uc.article_id')
            ->join('user u', 'u.id = a.user_id')
            ->join('theme t', 't.id = a.theme_id')
            ->where($whereData)
            ->select();
    }

    /**
     * 通用化获取参数的数据字段
     * @return array
     */
    private function _getListField()
    {
        return [
            'a.img as img',
            't.img as theme_img',
            'a.id as id',
            'a.user_id as user_id',
            't.id as theme_id',
            'a.is_position as is_position',
            'u.avatar as user_avatar',
            'u.nickname as user_nickname',
            'u.signature as signature',
            'a.create_time',
            'theme_introduction',
            'likes',
            'comments',
            'theme_name',
            'content',
            'a.is_sticky',
        ];
    }

}
