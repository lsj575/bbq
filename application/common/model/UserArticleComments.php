<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/21
 * Time: 11:05 AM
 */
namespace app\common\model;

/**
 * 用户评论点赞模型
 */
class UserArticleComments extends Base
{
    /**
     * 获取评论是否被点赞
     * @param $data
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBoolOfArticleCommentUpvote($data)
    {
        return $this->where('article_comment_id', 'in', $data['article_comment_id'])
            ->where('user_id', '=', $data['user_id'])
            ->select();
    }
}