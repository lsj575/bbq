<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/30
 * Time: 6:18 PM
 */
namespace app\api\controller\v1;

use app\api\controller\CommonController;

class SearchController extends CommonController
{
    /**
     * 搜索
     * @return \json
     */
    public function read()
    {
        if (request()->isGet()) {
            $getData = input('param.');

            // validate
            $validate = validate('search');
            if (!$validate->check($getData, [], 'read')) {
                return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
            }

            try {
                // 查询用户表、主题表、动态表
                $users = model('User')
                    ->field('id, nickname, signature, avatar')
                    ->where('nickname|signature', 'like', '%' . $getData['search_str'] . '%')
                    ->limit(3)
                    ->select();
                $themes = model('Theme')
                    ->field('id, theme_name, img, theme_introduction')
                    ->where('theme_introduction', 'like', '%' . $getData['search_str'] . '%')
                    ->limit(3)
                    ->select();
                $articles = model('Article')->searchArticleByContent($getData['search_str']);

                // 整理数据
                $data = [
                    'users'     => $users ? $this->adjustUsersData($users) : [],
                    'themes'    => $themes ? $this->adjustThemesData($themes) : [],
                    'articles'  => $articles ? $this->adjustArticlesData($articles) : [],
                ];

                return apiReturn(config('code.app_show_success'), 'OK', $data, 200);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '非法请求', [], 403);
        }
    }

    /**
     * 整理用户表数据
     * @param $users
     * @return array
     */
    private function adjustUsersData($users)
    {
        $result = [];
        foreach ($users as $key => $user) {
            $result[] = [
                'user_id'            => $user['id'],
                'user_nickname'     => $user['nickname'],
                'user_avatar'       => $user['avatar'],
                'user_signature'    => $user['signature'],
            ];
        }
        return $result;
    }

    /**
     * 整理主题表数据
     * @param $themes
     * @return array
     */
    private function adjustThemesData($themes)
    {
        $result = [];
        foreach ($themes as $key => $theme) {
            $result[] = [
                'theme_id'              => $theme['id'],
                'theme_name'            => $theme['theme_name'],
                'theme_img'             => $theme['img'],
                'theme_introduction'    => $theme['theme_introduction'],
            ];
        }
        return $result;
    }

    /**
     * 整理动态表数据
     * @param $articles
     * @return array
     */
    private function adjustArticlesData($articles)
    {
        $result = [];
        foreach ($articles as $key => $article) {
            $result[] = [
                'user_id'               => $article['user_id'],
                'article_id'            => $article['id'],
                'theme_id'              => $article['theme_id'],
                'theme_name'            => $article['theme_name'],
                'theme_introduction'    => $article['theme_introduction'],
                'article_content'               => $article['content'],
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
        return $result;
    }
}
