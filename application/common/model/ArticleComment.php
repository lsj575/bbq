<?php
namespace app\common\model;

use think\Db;
use think\Model;

/**
 * 动态评论模型
 * Class ArticleComment
 * @package app\common\model
 */
class ArticleComment extends Base
{
    /**
     * 通过条件获取评论数量
     * @param array $param
     * @return int|string
     */
    protected $table = 'article_comment';

    /**
     * 后台获取评论
     * @param array $data
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getComment($data = []) {
        $whereData = [];

        // 按评论内容搜索
        if(!empty($data['content'])){
            $whereData['ac.content'] = ['like',"%" . $data['content'] . "%"];
        }

        // 按评论者昵称搜搜
        if(!empty($data['nickname'])){
            $whereData['u.nickname'] = ['like',"%" . $data['nickname'] . "%"];
        }

        // 按所属动态的id搜索
        if (!empty($data['article_id'])) {
            $whereData['ac.article_id'] = ['=', $data['article_id']];
        }

        // 不要已经被删除的评论
        $data['ac.status'] = [
            'neq',config('code.status_delete')
        ];

        $results = $this->table($this->table)
            ->alias('ac')
            ->field([
                'ac.id',
                'u.id as user_id',
                'u.nickname',
                'u.avatar',
                'ac.content',
                'ac.parent_id',
                'ac.article_id',
                'ac.status',
                'ac.likes',
                'ac.img'
            ])
            ->join('user u', 'u.id = ac.user_id')
            ->where($whereData)
            ->paginate(5);

        return $results;
    }

    public function getAdviceComment($user_id)
    {
        $whereData1 = [
            'ac.status' => config('code.status_normal'),
            'a.status'  => config('code.status_normal'),
            'a.user_id' => $user_id,
        ];

        $whereData2 = [
            'ac1.status'    => config('code.status_normal'),
            'ac2.status'    => config('code.status_normal'),
            'ac1.user_id'   => $user_id,
        ];

        // 用户动态的评论
        $commentsOfArticle = $this->table('article')
            ->alias('a')
            ->field([
                'ac.id as comment_id',
                'u.id as user_id',
                'u.nickname as user_nickname',
                'u.avatar as user_avatar',
                'ac.content as comment_content',
                'ac.parent_id',
                'ac.article_id',
                'ac.likes as comment_likes',
                'ac.img as comment_img',
                'ac.create_time as create_time',
            ])
            ->join('article_comment ac', 'ac.article_id = a.id')
            ->join('user u', 'u.id = ac.user_id')
            ->where($whereData1)
            ->order('ac.create_time desc')
            ->select();

        // 用户评论的回复
        $commentsOfComment =  $this->table($this->table)
            ->alias('ac1')
            ->field([
                'ac2.id as comment_id',
                'u.id as user_id',
                'u.nickname as user_nickname',
                'u.avatar as user_avatar',
                'ac2.content as comment_content',
                'ac2.parent_id',
                'ac2.article_id',
                'ac2.likes as comment_likes',
                'ac2.img as comment_img',
                'ac2.create_time as create_time',
            ])
            ->join('article_comment ac2', 'ac2.parent_id = ac1.id')
            ->join('user u', 'u.id = ac2.user_id')
            ->where($whereData2)
            ->order('ac2.create_time desc')
            ->select();

        return $commentsOfArticle + $commentsOfComment;
    }

    /**
     * 按条件获取正常的评论
     * @param array $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getNormalCommentsByCondition($param = [])
    {
        $param['ac.status'] = config('code.user_normal');

        return collection($this->table($this->table)
            ->alias('ac')
            ->where($param)
            ->field([
                'ac.id',
                'u.nickname',
                'u.avatar',
                'ac.content',
                'ac.parent_id',
                'ac.article_id',
                'ac.status',
                'ac.likes',
                'ac.img',
                'ac.create_time',
            ])
            ->join('user u', 'u.id = ac.user_id')
            ->select())
            ->toArray();
    }

}
