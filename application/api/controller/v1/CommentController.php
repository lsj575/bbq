<?php
namespace app\api\controller\v1;

use app\api\controller\CommonController;
use app\common\lib\exception\ApiException;

class CommentController extends CommonController
{
    public function save()
    {
        $data = input('post.');

        //article_id content to_user_id parent_id
        //validate

        //查询文章
    }


    public function read()
    {
        //select * from ent_comment as a join user as b on a.user_id = b.id and a.news_id =;
        $articleid = input('param.id', 0, 'intval');
        if (empty($articleid)) {
            return new ApiException('id is not ', 404);
        }

        $param['article_id'] = $articleid;

        $count = model('ArticleComment')->getNormalCommentsCountByCondition($param);

        $this->getPageAndSize(input('param.'));
        $comments = model('ArticleComment')->getNormalCommentsByCondition($param, $this->from, $this->size);

        if ($comments) {
            foreach ($comments as $comment) {
                $userIds[];
            }
        }
    }

}
