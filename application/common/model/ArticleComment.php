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
                'ac.like',
                'ac.img'
            ])
            ->join('user u', 'u.id = ac.user_id')
            ->where($whereData)
            ->paginate(5);

        return $results;
    }

    /**
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
                'ac.like',
                'ac.img',
                'ac.create_time',
            ])
            ->join('user u', 'u.id = ac.user_id')
            ->select())
            ->toArray();
    }

}
