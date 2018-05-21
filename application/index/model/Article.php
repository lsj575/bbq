<?php
namespace app\index\model;

use think\Model;

class Article extends Model
{
    protected $table = 'article';

    public function articleMentionuser()
    {
        return $this->hasMany('ArticleMentionuser');
    }
    public function articleImg()
    {
        return $this->hasMany('ArticleImg');
    }
    public function addArticle($data, $imgs)
    {
        $this->startTrans();
        try {
            $this->data([
                'user_id'     => $data['user_id'],
                'content'     => isset($data['content'])?:null,
                'url'         => isset($data['url'])?:null,
                'create_time' => time(),
                'update_time' => time(),
            ]);

            $res = $this->save();

            if($res !== false) {
                if (isset($data['at_user_id']) && !is_null($data['at_user_id'])) {
                    foreach ($data['at_user_id'] as $val) {
                        $this->articleMentionuser()->save(['user_id' => $val]);
                    }
                }
                if () {

                    foreach ($imgs as $val) {
                        $this->articleMentionuser()->save([
                            'path' => $val,
                            'create_time' => time(),
                            'update_time' => time(),
                        ]);
                    }
                }
                return ['code' => 0, 'msg' => 'Success!', 'data' => null];
            } else {
                return ['code' => 30002, 'msg' => 'New article failed!', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            $this->rollback();
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }
}