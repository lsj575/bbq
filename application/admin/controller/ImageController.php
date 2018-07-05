<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * Class ImageController
 * @package app\admin\controller
 * 后台图片上传逻辑
 */
class ImageController extends BaseController
{
    /**
     * 图片上传
     */
    public function upload()
    {
        $file = Request::instance()->file('file');
        // 把图片上传到指定的文件夹
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

        //TODO 将返回方式进行封装，将图片路径修改为url的形式
        if ($info && $info->getSaveName()){
            $data = [
                'status' => 1,
                'message'=> 'OK',
                'data'   => $info->getSaveName(),
            ];
            echo json_encode($data);
        }else {
            echo json_encode(['status' => 0, 'message' => '上传失败']);
        }

    }
}