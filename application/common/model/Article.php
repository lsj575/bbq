<?php
namespace app\common\model;

class Article extends Base
{
    protected $table = 'article';

    /**
     * 获取被推荐的文章
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
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
     * 获取某主题下的所有动态
     * @param $data
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getArticleOfTheme($data)
    {
        $whereData = [
            'a.status'      => config('code.status_normal'),
            'u.status'      => config('code.status_normal'),
            'a.theme_id'    => $data['theme_id'],
        ];

        $order = [
            'a.create_time' => 'desc',
        ];
        return $this->table($this->table)
            ->alias('a')
            ->join('user u', 'a.user_id = u.id')
            ->field('a.*, u.nickname, u.avatar')
            ->where($whereData)
            ->order($order)
            ->select();
    }

    /**
     * 获取5天内获赞数最多的动态
     * @param $offset
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMostLikeArticles($offset)
    {
        $whereData = [
            'a.status'  => config('code.status_normal'),
            'u.status'  => config('code.status_normal'),
            't.status'  => config('code.status_normal'),
        ];

        // 五天前的时间戳
        $time = time() - 432000;

        return $this->table($this->table)
            ->alias('a')
            ->field($this->_getListField())
            ->join('user u', 'u.id = a.user_id')
            ->join('theme t', 't.id = a.theme_id')
            ->where($whereData)
            ->where('a.create_time', '>', time() - $time)
            ->order('a.likes desc, a.comments desc')
            ->limit($offset, $offset + 30)
            ->select();
    }

    /**
     * 获取后台管理员推荐动态
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAdminRecommendArticles()
    {
        $whereData = [
            'a.status'      => config('code.status_normal'),
            'u.status'      => config('code.status_normal'),
            't.status'      => config('code.status_normal'),
            'a.is_position' => config('code.is_position'),
        ];

        // 五天前的时间戳
        $time = time() - 432000;

        return $this->table($this->table)
            ->alias('a')
            ->field($this->_getListField())
            ->join('user u', 'u.id = a.user_id')
            ->join('theme t', 't.id = a.theme_id')
            ->where($whereData)
            ->where('a.create_time', '>', time() - $time)
            ->order('a.likes desc, a.comments desc')
            ->select();
    }

    /**
     * 获取用户的动态
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getArticleOfUser($id)
    {
        $whereData = [
            'a.user_id' => $id,
            'a.status'  => config('code.status_normal'),
            'u.status'  => config('code.status_normal'),
        ];

        return $this->table($this->table)
            ->alias('a')
            ->field($this->_getListField())
            ->join('user u', 'u.id = a.user_id')
            ->join('theme t', 't.id = a.theme_id')
            ->where($whereData)
            ->order('a.create_time desc')
            ->select();
    }

    /**
     * 获取用户关注的主题，用户关注的用户的动态
     * @param $id
     * @param $offset
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getArticlesOfUserAttention($id, $offset)
    {
        $whereData = [
            'u.id'      => $id,
            'a.status'  => config('code.status_normal'),
            'u.status'  => config('code.status_normal'),
        ];

        // 关注的用户的动态
        $user_article = $this->table('user')
            ->alias('u')
            ->field($this->_getListField())
            ->join('user_attention_user uau', 'uau.attention_user_id = u.id')
            ->join('article a', 'a.user_id = uau.be_attention_user_id')
            ->join('theme t', 't.id = a.theme_id')
            ->where($whereData)
            ->limit($offset, $offset+30)
            ->order('a.create_time desc')
            ->select();

        // 关注的主题的动态
        $theme_article = $this->table('user')
            ->alias('u')
            ->field($this->_getListField())
            ->join('user_attention_theme uat', 'uat.user_id = u.id')
            ->join('article a', 'a.theme_id = uat.theme_id')
            ->join('theme t', 't.id = a.theme_id')
            ->where($whereData)
            ->limit($offset, $offset+30)
            ->order('a.create_time desc')
            ->select();

        return $ans = [
            'user'  => $user_article,
            'theme' => $theme_article
        ];
    }

    /**
     * 按动态内容搜索动态
     * @param $str
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function searchArticleByContent($str)
    {
        return $this->table($this->table)
            ->alias('a')
            ->field($this->_getListField())
            ->join("theme t", 'a.theme_id = t.id')
            ->join('user u', 'a.user_id = u.id')
            ->where('content', 'like', '%' . $str . '%')
            ->limit(3)
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
            'a.create_time',
            'theme_introduction',
            'likes',
            'comments',
            'theme_name',
            'content',
        ];
    }

    /**
     * 获取正常状态的文章数量
     * @param $data
     * @return int|string
     */
    public function getNormalArticleCount($data)
    {
        $data['status'] = config('code.status_normal');

        return $this->where($data)
            ->count();
    }
}