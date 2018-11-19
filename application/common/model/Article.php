<?php
namespace app\common\model;

class Article extends Base
{
    /**
     * 获取首页头图文章
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getIndexHeadNormalArticle($num = 4)
    {
        $data = [
            'status'         => 1,
            'is_head_figure' => 1,
        ];

        //按更新时间排序
        $order = [
            'update_time' =>  'desc',
        ];

        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }


    /**
     * 获取被推荐的文章
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getPositionNormalArticle($num = 15)
    {
        $data = [
            'status'      => 1,
            'is_position' => 1,
        ];

        //按更新时间排序
        $order = [
            'update_time' =>  'desc',
        ];

        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }


    /**
     * 获取高赞文章
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getLikesNormalArticle($num = 15)
    {
        $data = [
            'status'      => 1,
        ];

        //按更新时间排序
        $order = [
            'likes' =>  'desc',
        ];

        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }


    /**
     * 通用化获取参数的数据字段
     * @return array
     */
    private function _getListField()
    {
        return [
            'id',
            'user_id',
            'theme_id',
            'content',
            'likes',
            'read_count',
        ];
    }
}