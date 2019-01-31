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
     */
    public function collectionArticle()
    {
        // 动态id
        $id = input('post.id', 0, 'intval');

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
                'user_id'       => $this->user->id,
                'article_id'    => $id,
            ];
            model('UserCollection')->startTrans();
            try {
                // 查询数据库中是否存在该关注
                $userCollection = model('UserCollection')->get($data);
                if ($userCollection) {
                    return apiReturn(config('code.app_show_error'), '已收藏,请勿重复收藏', [], 401);
                }
                // 未被关注
                $userCollectionId = model('UserCollection')->add($data);
                if ($userCollectionId) {
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
     * 获取主题是否被某用户关注
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
            return apiReturn(config('code.app_show_error'), '不存在该主题', [], 403);
        }
    }

}