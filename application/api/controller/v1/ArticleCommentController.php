<?php
namespace app\api\controller\v1;

use app\api\controller\CommonController;
use app\common\lib\exception\ApiException;

/**
 * 评论控制器
 * Class ArticleCommentController
 * @package app\api\controller\v1
 */
class ArticleCommentController extends AuthBaseController
{
    /**
     * 添加评论
     * @return \json
     * @throws ApiException
     */
    public function save()
    {
        // strip_tags 剥去字符串中的 HTML、XML 以及 PHP 的标签
        $data = input('post.', [], 'strip_tags');

        //article_id content to_user_id parent_id
        //validate
        $validate = validate('ArticleComment');
        if (!$validate->check($data, [], 'save')) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), [], 403);
        }

        // content和img不能同时为空
        if (!$data['content'] && !$data['img']) {
            return apiReturn(config('code.app_show_error'), '文字评论和图片评论需要至少添加一项', [], 403);
        }

        // 查询动态是否正常
        // 判断此id的文章是否存在，且状态是否正常
        try {
            $article = model('Article')->get(['id' => $data['article_id'], 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if (!$article) {
            return apiReturn(config('code.app_show_error'), '动态不存在', [], 403);
        }

        $data['user_id'] =$this->user->id;

        try {
            $commentId = model('ArticleComment')->add($data);
            if ($commentId) {
                return apiReturn(config('code.app_show_success'), 'OK', [], 202);
            } else {
                return apiReturn(config('code.app_show_error'), '评论失败', [], 500);
            }
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * 获取某动态下的评论
     * @return ApiException|\json
     * @throws ApiException
     */
    public function read()
    {
        $article_id = input('param.id', 0, 'intval');
        if (!$article_id) {
            return new ApiException('id is not ', 404);
        }

        $param['article_id'] = $article_id;

        try {
            $article_comments = model('ArticleComment')->getNormalCommentsByCondition($param);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($article_comments) {
            // 组织树形的返回结构
            $result = [];
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($article_comments as $key => $article_comment) {
                $refer[$article_comment['id']] = &$article_comments[$key];
            }
            foreach ($article_comments as $key => $article_comment) {
                // 判断是否存在parent
                $parentId = $article_comment['parent_id'];
                // parent_id为0表示没有父评论
                if (0 == $parentId) {
                    $result[] = &$article_comments[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent = &$refer[$parentId];
                        $parent['son'][] = &$article_comments[$key];
                    }
                }
            }
            return apiReturn(config('code.app_show_success'), 'OK', $result, 202);
        } else {
            return apiReturn(config('code.app_show_success'), '暂无评论', [], 202);
        }
    }

}
