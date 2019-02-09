<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/21
 * Time: 10:25 AM
 */
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use think\Db;
/**
 * 点赞相关
 * Class UpvoteController
 * @package app\api\controller\v1
 */
class UpvoteController extends AuthBaseController
{
    /**
     * 给动态点赞
     * @return \json
     * @throws ApiException
     */
    public function saveUserArticles()
    {
        $id = input('post.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }
        // 判断此id的文章是否存在，且状态是否正常
        try {
            $article = model('Article')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($article) {
            $data = [
                'user_id' => $this->user->id,
                'article_id' => $id,
            ];
            Db::startTrans();
            try {
                // 查询数据库中是否存在点赞
                $userArticle = Db::table('user_articles')->where($data)->find();
                if ($userArticle) {
                    return apiReturn(config('code.app_show_error'), '已点赞,请勿重复点赞', [], 401);
                }
                $data['create_time'] = time();
                $userArticleId = Db::table('user_articles')->insert($data);
                if ($userArticleId) {
                    Db::table('article')->where(['id' => $id])->setInc('likes');
                    Db::commit();
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，点赞失败', [], 500);
                }
            } catch (\Exception $e) {
                Db::rollback();
                throw new ApiException($e->getMessage(), 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该动态', [], 403);
        }
    }

    /**
     * 取消点赞
     * @return \json
     * @throws ApiException
     */
    public function deleteUserArticles()
    {
        $id = input('delete.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }

        // 判断此id的文章是否存在，且状态是否正常
        try {
            $article = model('Article')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($article) {
            $data = [
                'user_id' => $this->user->id,
                'article_id' => $id,
            ];
            Db::startTrans();
            try {
                // 查询数据库中是否存在点赞
                $userArticle = Db::table('user_articles')->where($data)->find();
                if (!$userArticle) {
                    return apiReturn(config('code.app_show_error'), '没有被点赞过，无法取消', [], 401);
                }
                $userArticleId = Db::table('user_articles')->where($data)->delete();
                if ($userArticleId) {
                    Db::table('article')->where(['id' => $id])->setDec('likes');
                    Db::commit();
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，取消点赞失败', [], 500);
                }
            } catch (\Exception $e) {
                Db::rollback();
                throw new ApiException($e->getMessage(), 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该动态', [], 403);
        }
    }

    /**
     * 获取动态是否被点赞
     * @return \json
     * @throws ApiException
     */
    public function readUserArticles()
    {
        // 接收数组参数，/a为必加，去掉会报错
        $article_id = input('param.id/a', []);

        if (!$article_id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }

        $whereData = [
            'article_id'    => $article_id,
            'user_id'       => $this->user->id
        ];
        try {
            // 查询数据库中是否存在点赞
            $userArticles = model('UserArticles')->getBoolOfArticleUpvote($whereData);
            if ($userArticles) {
                // 整理返回的数据
                $result = [];
                foreach ($userArticles as $key => $userArticle) {
                    $result[] = $userArticle['article_id'];
                }
                return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
            } else {
                return apiReturn(config('code.app_show_success'), 'OK', [], 200);
            }
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * 评论点赞
     * @return \json
     * @throws ApiException
     */
    public function saveUserArticleComments()
    {
        $id = input('post.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }
        // 判断此id的评论是否存在，且状态是否正常
        try {
            $article_comment = model('ArticleComment')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($article_comment) {
            $data = [
                'user_id'               => $this->user->id,
                'article_comment_id'    => $id,
            ];
            Db::startTrans();
            try {
                // 查询数据库中是否存在点赞
                $userArticleComment = Db::table('user_article_comments')->where($data)->find();
                if ($userArticleComment) {
                    return apiReturn(config('code.app_show_error'), '已点赞,请勿重复点赞', [], 401);
                }
                $data['create_time'] = time();
                $userArticleCommentId = Db::table('user_article_comments')->insert($data);
                if ($userArticleCommentId) {
                    Db::table('article_comment')->where(['id' => $id])->setInc('likes');
                    Db::commit();
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，点赞失败', [], 500);
                }
            } catch (\Exception $e) {
                Db::rollback();
                throw new ApiException($e->getMessage(), 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该评论', [], 403);
        }
    }

    /**
     * 取消评论点赞
     * @return \json
     * @throws ApiException
     */
    public function deleteUserArticleComments()
    {
        $id = input('delete.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }

        // 判断此id的评论是否存在，且状态是否正常
        try {
            $article_comment = model('ArticleComment')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($article_comment) {
            $data = [
                'user_id'               => $this->user->id,
                'article_comment_id'    => $id,
            ];
            Db::startTrans();
            try {
                // 查询数据库中是否存在点赞
                $userArticleComment = Db::table('user_article_comments')->where($data)->find();
                if (!$userArticleComment) {
                    return apiReturn(config('code.app_show_error'), '没有被点赞过，无法取消', [], 401);
                }
                $userArticleCommentId = Db::table('user_article_comments')->where($data)->delete();
                if ($userArticleCommentId) {
                    Db::table('article_comment')->where(['id' => $id])->setDec('likes');
                    Db::commit();
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，取消点赞失败', [], 500);
                }
            } catch (\Exception $e) {
                Db::rollback();
                throw new ApiException($e->getMessage(), 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该评论', [], 403);
        }
    }

    /**
     * 获取评论是否被点赞
     * @return \json
     * @throws ApiException
     */
    public function readUserArticleComments()
    {
        // 接收数组参数，/a为必加，去掉会报错
        $article_comment_id = input('param.id/a', []);

        if (!$article_comment_id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }

        $whereData = [
            'article_comment_id'    => $article_comment_id,
            'user_id'               => $this->user->id
        ];
        try {
            // 查询数据库中是否存在点赞
            $userArticleComments = model('UserArticleComments')->getBoolOfArticleCommentUpvote($whereData);
            if ($userArticleComments) {
                // 整理返回的数据
                $result = [];
                foreach ($userArticleComments as $key => $userArticleComment) {
                    $result[] = $userArticleComment['article_comment_id'];
                }
                return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
            } else {
                return apiReturn(config('code.app_show_success'), 'OK', [], 200);
            }
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }
}