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

    public function getComment($data=[]) {
        $whereData = [];

        //按评论内容搜索
        if(!empty($data['content'])){
            $whereData['m.content'] = ['like',"%".$data['content']."%"];
        }

        //按评论者昵称搜搜
        if(!empty($data['nickname'])){
            $whereData['u.nickname'] = ['like',"%".$data['nickname']."%"];
        }

        //按所属动态的id搜索
        if (!empty($data['article_id'])) {
            $whereData['m.article_id'] = ['=',$data['article_id']];
        }

        //不要已经被删除的评论
        $data['m.status'] = [
            'neq',config('code.status_delete')
        ];

        $results = $this->table($this->table)
            ->alias('m')
            ->field([
                'm.id',
                'u.id as user_id',
                'u.nickname',
                'm.content',
                'm.parent_id',
                'm.article_id',
                'm.status',
                'm.like',
                'm.img'
            ])
            ->join("user u", 'u.id= m.user_id')
            ->where($whereData)
            ->paginate(5);

        return $results;
    }

    public function getNormalCommentsCountByCondition($param = [])
    {
        $param['status'] = config('code.user_normal');

        return $this->where($param)
            ->field('id')
            ->count();
    }

    public function getNormalCommentsByCondition($param = [], $from = 0, $size = 5)
    {
        $param['status'] = config('code.user_normal');

        return $this->where($param)
            ->field('*')
            ->limit($from, $size)
            ->order(['id' => 'desc'])
            ->select();
    }
}
