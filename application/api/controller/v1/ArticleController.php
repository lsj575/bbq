<?php
/**
 * Created by PhpStorm.
 * User: 76871
 * Date: 2018/8/13
 * Time: 15:52
 */
namespace app\api\controller\v1;

use app\api\controller\CommonController;
use app\common\lib\exception\ApiException;

class ArticleController extends CommonController
{
    /**
     * 获取某主题下的所有动态
     * @return \json
     * @throws ApiException
     */
    public function getArticlesOfTheme()
    {
        if (request()->isGet()) {
            $getData = input('get.');

            // validate
            $validate = validate('Article');
            if (!$validate->check($getData, [], 'getArticlesOfTheme')) {
                return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
            }

            // 整理数据
            $data = [
                'theme_id'  => $getData['theme_id'],
            ];

            // 查库
            try {
                $articles = model('Article')->getArticleOfTheme($data);
            }catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500);
            }

            // 整理返回值
            $result = [];
            foreach ($articles as $key => $article) {
                $result[] = [
                    'article_id'    => $article['id'],
                    'content'       => $article['content'],
                    'img'           => $article['img'],
                    'likes'         => $article['likes'],
                    'user_nickname' => $article['nickname'],
                    'user_avatar'   => $article['avatar'],
                    'create_time'   => $article['create_time'],
                ];
            }
            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
        }
    }

    /**
     * 发布动态，需要提升权限要求到登录用户权限
     * @return \json
     * @throws ApiException
     */
    public function save()
    {
        if (request()->isPost()) {
            // 提升权限要求
            $auth = new AuthBaseController();

            $param = input('post.');

            // validate
            $validate = validate('article');
            if (!$validate->check($param, [], 'save')) {
                return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
            }

            // 文字内容和图片不能全为空
            if ($param['img'] || $param['content']) {
                // 整理入库数据
                $data = [
                    'theme_id'          => $param['theme_id'],
                    'user_id'           => $auth->user->id,
                    'content'           => empty($param['content']) ? '' : $param['content'],
                    'img'               => empty($param['img']) ? '' : implode($param['img'], ','),
                    'allow_watermark'   => $param['allow_watermark'],
                    'allow_comment'     => $param['allow_comment'],
                ];
            } else {
                return apiReturn(config('code.app_show_error'), '内容和图片不能全为空', '', 403);
            }

            // 入库
            try {
                $id = model('article')->add($data);
            } catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500, config('code.app_show_error'));
            }

            if ($id) {
                return apiReturn(config('code.app_show_success'), 'ok', '', 200);
            } else {
                return apiReturn(config('code.app_show_error'), '发布动态失败', '', 500);
            }
        }
    }

    /**
     * 更新动态
     * @return \json
     */
    public function update()
    {
        // 提升权限要求
        $auth = new AuthBaseController();

        $putData = input('param.');
        // validate
        $validate = validate('Article');
        if (!$validate->check($putData, [], 'Article.update')) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
        }
        //严格判断要插入的数据
        $data = [];
        if (!empty($putData['content'])) {
            $data['content'] = $putData['content'];
        }
        if (!empty($putData['img'])) {
            $data['img'] = implode($putData['img'], ',');
        }
        if (!empty($putData['allow_comment'])) {
            $data['allow_comment'] = $putData['allow_comment'];
        }
        if (!empty($putData['allow_watermark'])) {
            $data['allow_watermark'] = $putData['allow_watermark'];
        }

        // 数据不能为空或者图片和内容不能同时为空
        if (empty($data) || (empty($data['img']) && empty($data['content']))) {
            return apiReturn(config('code.app_show_error'), '数据不合法', [], 404);
        }

        try {
            $article = model('Article')->get(['id' => $putData['id']]);
            // 该id文章存在且属于该用户
            if ($article && $auth->user->id == $article->user_id) {
                $id = model('Article')->save($data, ['id' => $article->id]);
                if ($id) {
                    return apiReturn(config('code.app_show_success'), 'ok', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '更新失败', [], 401);
                }
            } else {
                return apiReturn(config('code.app_show_error'), '动态不存在', [], 403);
            }

        } catch (\Exception $e) {
            return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
        }
    }

    /**
     * 判断是否存在某个id的文章且状态正常
     * @param $id
     * @return bool
     * @throws ApiException
     */
    public function isExistsTheArticle($id)
    {
        try {
            $count = model('Article')->getNormalArticleCount($id);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($count) {
            return true;
        } else {
            return false;
        }
    }

}