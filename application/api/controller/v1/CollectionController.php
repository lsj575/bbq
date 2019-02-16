<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/12/6
 * Time: 3:34 PM
 */
namespace app\api\controller\v1;


use app\common\lib\exception\ApiException;

class CollectionController extends AuthBaseController
{
    /**
     * 收藏动态
     * @return \json
     * @throws ApiException
     * @throws \think\exception\PDOException
     */
    public function collectionArticle()
    {
        // 动态id
        $id = input('post.id', 0, 'intval');

        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }
        // 判断此id的动态是否存在，且状态是否正常
        try {
            $article = model('article')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($article) {
            $data = [
                'user_id'       => $this->user->id,
                'article_id'    => $id,
            ];
            model('UserCollection')->startTrans();
            try {
                // 查询数据库中是否存在该收藏
                $userCollection = model('UserCollection')->get($data);
                if ($userCollection) {
                    return apiReturn(config('code.app_show_error'), '已收藏,请勿重复收藏', [], 401);
                }
                // 未被收藏
                $userCollectionId = model('UserCollection')->add($data);
                if ($userCollectionId) {
                    model('UserCollection')->commit();
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，收藏失败', [], 500);
                }
            } catch (\Exception $e) {
                model('UserCollection')->rollback();
                throw new ApiException($e->getMessage(), 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该动态', [], 403);
        }
    }

    /**
     * 取消收藏动态
     * @return \json
     * @throws ApiException
     * @throws \think\exception\PDOException
     */
    public function deleteCollection()
    {
        $id = input('delete.id', 0, 'intval');

        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }

        // 判断此id的主题是否存在，且状态是否正常
        try {
            $article = model('article')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($article) {
            $data = [
                'user_id' => $this->user->id,
                'article_id' => $id,
            ];
            model('UserCollection')->startTrans();
            try {
                // 查询数据库中是否存在关注
                $userCollection = model('UserCollection')->get($data);
                if (empty($userCollection)) {
                    return apiReturn(config('code.app_show_error'), '没有被收藏过，无法取消', [], 401);
                }
                $userCollectionId = model('UserCollection')->where($data)->delete();
                if ($userCollectionId) {
                    model('UserCollection')->commit();
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，取消收藏失败', [], 500);
                }
            } catch (\Exception $e) {
                model('UserCollection')->rollback();
                throw new ApiException($e->getMessage(), 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该动态', [], 403);
        }
    }


    /**
     * 获取动态是否被某用户收藏
     * @return \json
     * @throws ApiException
     */
    public function getBoolOfCollection()
    {
        $id = input('param.id', 0, 'intval');
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

            try {
                // 查询数据库中是否存在关注
                $userCollection = model('UserCollection')->get($data);
                if ($userCollection) {
                    return apiReturn(config('code.app_show_success'), 'OK', ['isCollection' => 1], 200);
                } else {
                    return apiReturn(config('code.app_show_success'), 'OK', ['isCollection' => 0], 200);
                }
            } catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该动态', [], 403);
        }
    }

    /**
     * 获取用户收藏的动态
     * @return \json
     */
    public function getArticleOfUserCollect()
    {
        if (request()->isGet()) {
            try {
                $articles = model('UserCollection')->getArticleOfUserCollect($this->user->id);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }

            // 整理数据
            $result = [];
            if ($articles) {
                foreach ($articles as $key => $article) {
                    $result[] = $this->organizeDataOfArticle($article);
                }
            }

            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
        } else {
            return apiReturn(config('code.app_show_error'), 'error', [], 403);
        }
    }

    /**
     * 整理动态数据
     * @param $article
     * @return array
     */
    private function organizeDataOfArticle($article)
    {
        return [
            'user_id'               => $article['user_id'],
            'article_id'            => $article['id'],
            'theme_id'              => $article['theme_id'],
            'theme_name'            => $article['theme_name'],
            'theme_introduction'    => $article['theme_introduction'],
            'article_content'       => $article['content'],
            'article_img'           => $article['img'] ? explode(',', $article['img']) : "",
            'theme_img'             => $article['theme_img'],
            'likes'                 => $article['likes'],
            'comments'              => $article['comments'],
            'user_nickname'         => $article['user_nickname'],
            'user_avatar'           => $article['user_avatar'],
            'user_signature'        => $article['signature'],
            'is_position'           => $article['is_position'],
            'create_time'           => $article['create_time'],
            'is_sticky'             => $article['is_sticky'],
        ];
    }
}
