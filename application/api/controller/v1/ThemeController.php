<?php
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use app\api\controller\CommonController;

class ThemeController extends CommonController
{
    /**
     * 获取所有主题接口
     * @return \json
     * @throws ApiException
     */
    public function getAllTheme()
    {
        $data['status'] = [
            'eq', config('code.status_normal')
        ];
        try {
            $themes = model('Theme')->where($data)->select();
        }catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        $result = [];
        if ($themes) {
            foreach ($themes as $key => $theme) {
                $result[] = [
                    'theme_id'              => $theme['id'],
                    'theme_name'            => $theme['theme_name'],
                    'theme_introduction'    => $theme['theme_introduction'],
                    'img_url'               => $theme['img'],
                ];
            }
        }


        return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
    }

    /**
     * 获取用户关注的主题
     * @return \json
     */
    public function getThemeOfUserAttention()
    {
        if (request()->isGet()) {
            $auth = new AuthBaseController();
            $id = input('get.id') ? input('get.id') : $auth->user->id;
            try {
                $themes = model('UserAttentionTheme')->getThemeOfUserAttention($id);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }

            // 整理数据
            $result = [];
            if ($themes) {
                foreach ($themes as $key => $theme) {
                    $result[] = [
                        'theme_id'              => $theme['id'],
                        'theme_img'             => $theme['img'],
                        'theme_name'            => $theme['theme_name'],
                        'theme_introduction'    => $theme['theme_introduction'],
                    ];
                }
            }

            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
        } else {
            return apiReturn(config('code.app_show_error'), 'error', [], 403);
        }
    }

    /**
     * 获取推荐主题
     * @return \json
     * @throws ApiException
     */
    public function getRecommendThemes()
    {
        if (request()->isGet()) {
            $offset = input('param.offset', 0, 'intval');

            try {
                $adminRecommendThemes = model('theme')->getRecommendThemes($offset);
            } catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500);
            }

            $result = [];
            if ($adminRecommendThemes) {
                foreach ($adminRecommendThemes as $key => $adminRecommendTheme) {
                    $result = [
                        'theme_id'              => $adminRecommendTheme['id'],
                        'theme_img'             => $adminRecommendTheme['img'],
                        'theme_name'            => $adminRecommendTheme['theme_name'],
                        'theme_introduction'    => $adminRecommendTheme['theme_introduction'],
                    ];
                }
            }

            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
        } else {
            return apiReturn(config('code.app_show_error'), '请求不合法', [], 403);
        }
    }

    /**
     * 获取某主题关注的用户数量
     * @return \json
     * @throws ApiException
     */
    public function getUserNumOfAttentionTheme()
    {
        if (request()->isGet()) {
            // 主题id
            $id = input('get.id', 0, 'intval');

            try {
                $count = model('UserAttentionTheme')->where(['theme_id' => $id])->count();
            } catch (\Exception $e) {
                throw new ApiException($e->getMessage(), 500);
            }
            return apiReturn(config('code.app_show_success'), 'OK', ['count' => $count], 200);
        } else {
            return apiReturn(config('code.app_show_error'), '非法请求', [], 403);
        }
    }
}