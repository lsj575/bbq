<?php
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use app\api\controller\CommonController;

class ThemeController extends CommonController
{
    /**
     * 主题接口
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
}