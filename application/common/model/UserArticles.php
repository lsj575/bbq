<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/21
 * Time: 11:05 AM
 */
namespace app\common\model;

use think\Model;

/**
 * 用户点赞模型
 */
class UserArticles extends Base
{
    /**
     * 获取动态是否被点赞
     * @param array $article_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBoolOfArticleUpvote($article_id = [])
    {
        return $this->where('id', 'in', $article_id)
            ->select();
    }
}