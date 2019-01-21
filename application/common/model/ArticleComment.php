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

    public function getComment($identity, $data=[]) {
        $data['m.status'] = [
            'neq',config('code.status_delete')
        ];
        if(isset($data['content'])) {
            $data['m.content'] = $data['content'];
            unset($data['content']);
        }
        if(isset($data['nickname'])) {
            $data['u.nickname'] = $data['nickname'];
            unset($data['nickname']);
        }

        if($identity=='commentator') {
            $identity='u.id = m.user_id';
        } else {
            $identity='u.id = m.to_user_id';
        }

        $results = model("User")
            ->alias('u')
            ->join("$this->table m", $identity)
            ->where($data)
            ->paginate(5);

        if (count($results)) {
            foreach($results as $result) {
                $result['user_id']= model("User")::get($result->user_id)->nickname;
                $result['to_user_id']=model("User")::get($result->to_user_id)->nickname;
            }
        }
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
