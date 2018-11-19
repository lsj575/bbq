<?php
namespace app\common\model;

use think\Db;
use think\Model;

class ArticleComment extends Base
{
    /**
     * 通过条件获取评论数量
     * @param array $param
     * @return int|string
     */
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