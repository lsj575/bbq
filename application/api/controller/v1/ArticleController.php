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
    public function getOneArticle()
    {
        if (request()->isGet()) {
            $data = input('get');

            $validate = validate('Article');
            if (!$validate->check($data, [], 'Article.getOne')) {
                return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
            }

            $data['status'] = [
                'eq', config('code.status_normal')
            ];
            try {
                $articles = model('Article')->where($data)->select();
            }catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500);
            }

            $result = [];
            foreach ($articles as $key => $article) {
                $result[] = [
                    'theme_id'   => $article['id'],
                    'theme_name' => $article['theme_name'],
                    'img_url'    => $article['img'],
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
                $data = [
                    'theme_id'          => $param['theme_id'],
                    'user_id'           => $auth->user->id,
                    'content'           => is_null($param['content']) ? '' : $param['content'],
                    'img'               => is_null($param['img']) ? '' : implode($param['img'], ','),
                    'allow_watermark'   => $param['img_watermark'],
                    'allow_comment'     => $param['allow_comment'],
                ];
            }
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