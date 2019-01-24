<?php
/*
 * 首页图片管理
 */
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use app\api\controller\CommonController;

class SlideImgController extends CommonController
{
    /**
    * 获取所有轮播图
    * @return \json
    * @throws ApiException
    */
    public function getImages()
    {
        $data['status'] = [
            'eq', config('code.status_normal')
        ];
        try {
            $images = model('slide_img')->where($data)->select();
        }catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        $result = [];
        foreach ($images as $key => $image) {
            $result[] = [
                'img_id'              => $image['id'],
                'img_description'     => $image['description'],
                'img_url'               => $image['img'],
                'img_type'              => $image['img_type']
            ];
        }
        return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
    }
}