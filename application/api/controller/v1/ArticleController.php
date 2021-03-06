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
use think\Db;

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
            if ($articles) {
                foreach ($articles as $key => $article) {
                    $result[] = [
                        'article_id'        => $article['id'],
                        'article_content'   => $article['content'],
                        'article_img'       => $article['img'] ? explode(',', $article['img']) : "",
                        'likes'             => $article['likes'],
                        'user_nickname'     => $article['nickname'],
                        'user_avatar'       => $article['avatar'],
                        'user_signature'    => $article['signature'],
                        'create_time'       => $article['create_time'],
                    ];
                }
            }

            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
        }
    }

    /**
     * 获取推荐动态
     * @return \json
     * @throws ApiException
     */
    public function getRecommendArticles()
    {
        if (request()->isGet()) {
            $offset = input('param.offset', 0, 'intval');
            // 查库
            try {
                // 推荐的动态分为点赞数最多和被管理员推荐的两部分
                $mostLikeArticles = model('Article')->getMostLikeArticles($offset);
                // 如果偏移量为0，也就是说用户第一次请求该接口，获取管理员推荐动态
                if (!$offset) {
                    $adminRecommendArticles = model('Article')->getAdminRecommendArticles();
                } else {
                    $adminRecommendArticles = null;
                }
            }catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500);
            }

            // 整理返回值
            $result = [];
            // 以下两行保证在admin_recommend或most_like没数据时，仍然可以返回数组类型数据（空数组），而不是不显示
            $result['admin_recommend'] = [];
            $result['most_like'] = [];
            if ($adminRecommendArticles) {
                foreach ($adminRecommendArticles as $key => $article) {
                    $result['admin_recommend'][] = $this->organizeDataOfArticle($article);
                }
            }
            if ($mostLikeArticles) {
                foreach ($mostLikeArticles as $key => $article) {
                    // 排除掉在admin_recommend中的数据
                    if ($article['is_position'] == 0) {
                        $result['most_like'][] = $this->organizeDataOfArticle($article);
                    }
                }
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
                return apiReturn(config('code.app_show_error'), $validate->getError(), [], 400);
            }

            // 文字内容和图片不能全为空
            if ($param['img'] || $param['content']) {
                // 整理入库数据
                $data = [
                    'theme_id'          => $param['theme_id'],
                    'user_id'           => $auth->user->id,
                    'content'           => $param['content'] ? $param['content'] : '',
                    'img'               => empty($param['img']) ? '' : implode(',', $param['img']),
                    'allow_watermark'   => $param['allow_watermark'],
                    'allow_comment'     => $param['allow_comment'],
                ];
            } else {
                return apiReturn(config('code.app_show_error'),
                    '内容和图片不能全为空', '', 403);
            }

            // 入库
            try {
                $id = model('article')->add($data);
            } catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500, config('code.app_show_error'));
            }

            if ($id) {
                return apiReturn(config('code.app_show_success'), 'ok', [], 200);
            } else {
                return apiReturn(config('code.app_show_error'), '发布动态失败', [], 500);
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
            return apiReturn(config('code.app_show_error'), $validate->getError(), [], 400);
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
        if (empty($data) && ($data['img'] || $data['content'])) {
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
            return apiReturn(config('code.app_show_error'), $e->getMessage(), [], 500);
        }
    }

    /**
     * 获取用户的动态
     * @return \json
     */
    public function getArticleOfUser()
    {
        if (request()->isGet()) {
            // 提升权限要求
            $auth = new AuthBaseController();
            $id = input('get.id') ? input('get.id') : $auth->user->id;
            try {
                $articles = model('Article')->getArticleOfUser($id);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), [], 500);
            }

            $result = [];
            if ($articles) {
                foreach ($articles as $key => $article) {
                    $result[] = $this->organizeDataOfArticle($article);
                }
            }

            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
        }
    }

    /**
     * 获取用户关注的所有动态
     * @return \json
     * @throws ApiException
     */
    public function getArticlesOfUserAttention()
    {
        if (request()->isGet()) {
            // 提升权限为手机登陆用户权限
            $auth = new AuthBaseController();

            $offset = input('param.offset', 0, 'intval');

            // 查库
            try {
                $articles = model('Article')->getArticlesOfUserAttention($auth->user->id, $offset);
            }catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500);
            }

            // 整理返回值
            $result = [];
            if ($articles) {
                foreach ($articles as $key => $unknownType_article) {
                    foreach ($unknownType_article as $article) {
                        $result[] = [
                            // type标识来自于关注的用户还是关注的主题
                            'type'                  => $key,
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
                        ];
                    }
                }
            }

            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
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

    /**
     * 删除动态
     * @return \json
     * @throws ApiException
     */
    public function delete()
    {
        if (request()->isDelete()) {
            // 提升权限为手机登陆用户权限
            $auth = new AuthBaseController();

            $article_id = input('delete.id', 0, 'intval');
            if (!$article_id) {
                return apiReturn(config('code.app_show_error'), '非法参数', [], 200);
            }

            // 查库
            try {
                $whereData = [
                    'id'        => $article_id,
                    'user_id'   => $auth->user->id,
                    'status'    => config('code.status_normal')
                ];
                $article = model('Article')->where($whereData)->select();
            }catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500);
            }

            // 如果动态没查到
            if (!$article) {
                return apiReturn(config('code.app_show_error'), '动态不存在或已被删除', [], 200);
            }

            // 开始执行删除操作
            Db::startTrans();
            try {
                // 1. 将动态状态置为删除态
                $count = Db::table('article')->where(['id' => $article_id])
                    ->update(['status' => config('code.status_delete')]);
                // 成功的话，影响的数据条数为1
                if ($count == 1) {
                    // 2. 将该动态的所有评论置为删除态
                    Db::table('article_comment')->where(['article_id' => $article_id])
                        ->update(['status' => config('code.status_delete')]);
                }
                Db::commit();
                return apiReturn(config('code.app_show_success'), 'OK', [], 200);
            } catch (\Exception $e) {
                Db::rollback();
                throw new ApiException($e->getMessage(), 500);
            }
        }
    }

    /**
     * 根据id获取动态信息
     * @return \json
     * @throws ApiException
     */
    public function getArticleInfoById()
    {
        if (request()->isGet()) {
            $article_id = input('get.id', 0, 'intval');

            if (!$article_id) {
                return apiReturn(config('code.app_show_error'), '参数不合法', [], 500);
            }
            // 整理数据
            $data = [
                'article_id'  => $article_id,
            ];

            // 查库
            try {
                $article = model('Article')->getArticleInfoById($data);
            }catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500);
            }

            // 整理返回值
            $result = [];
            if ($article) {
                $result[] = [
                    'article_id'        => $article_id,
                    'article_content'   => $article['content'],
                    'article_img'       => $article['img'] ? explode(',', $article['img']) : "",
                    'likes'             => $article['likes'],
                    'user_nickname'     => $article['nickname'],
                    'user_avatar'       => $article['avatar'],
                    'user_signature'    => $article['signature'],
                    'create_time'       => $article['create_time'],
                    'is_sticky'         => $article['is_sticky'],
                ];
            }

            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
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
            'article_img'                   => $article['img'] ? explode(',', $article['img']) : "",
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
