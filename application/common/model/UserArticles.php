<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/21
 * Time: 11:05 AM
 */
namespace app\common\model;

/**
 * 用户点赞模型
 */
class UserArticles extends Base
{
    /**
     * 获取动态是否被点赞
     * @param $data
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBoolOfArticleUpvote($data)
    {
        return $this->where('article_id', 'in', $data['article_id'])
            ->where('user_id', '=', $data['user_id'])
            ->select();
    }
}