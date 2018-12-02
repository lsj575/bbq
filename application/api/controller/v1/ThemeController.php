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
        foreach ($themes as $key => $theme) {
            $result[] = [
                'theme_id'   => $theme['id'],
                'theme_name' => $theme['theme_name'],
                'img_url'    => $theme['img'],
            ];
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
            try {
                $themes = model('UserAttentionTheme')->getThemeOfUserAttention($auth->user->id);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }

            // 整理数据
            $result = [];
            foreach ($themes as $key => $theme) {
                $result = [
                    'theme_id'      => $theme['id'],
                    'theme_img'     => $theme['img'],
                    'theme_name'    => $theme['theme_name'],
                ];
            }
            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
        } else {
            return apiReturn(config('code.app_show_error'), 'error', [], 403);
        }
    }
}