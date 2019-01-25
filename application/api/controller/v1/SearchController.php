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
                    ->where('nickname|signature', 'like', '%' . $getData['search_str'] . '%')
                    ->limit(3)
                    ->select();
                $themes = model('Theme')
                    ->where('theme_introduction', 'like', '%' . $getData['search_str'] . '%')
                    ->limit(3)
                    ->select();
                $articles = model('Article')->searchArticleByContent($getData['search_str']);

                // 整理数据
                $data = [
                    'users'     => $users ? $users : [],
                    'themes'    => $themes ? $themes : [],
                    'articles'  => $articles ? $articles : [],
                ];
                return apiReturn(config('code.app_show_success'), 'OK', $data, 200);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '非法请求', [], 403);
        }
    }
}
