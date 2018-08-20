<?php
namespace app\api\controller\v1;

use app\api\controller\CommonController;
use app\common\lib\exception\ApiException;
use think\Log;

class IndexController extends CommonController
{
    public function index()
    {
        try {
            $header = model('Article')->getIndexHeadNormalArticle();
            $positions = model('Article')->getPositionNormalArticle();
            $likes = model('Article')->getLikesNormalArticle();
        }catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * 客户端初始化接口
     * 1、检测APP是否需要升级
     * 2、记录用户的基本信息
     * @return ApiException|\json|\think\response\Json
     * @throws ApiException
     */
    public function init()
    {
        try {
            // app_type 去version表 查询 对比
            $version = model('Version')->getLastNormalVersionByAppType($this->headers['app_type']);
        }catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if (empty($version)) {
            return new ApiException('error', 404);
        }

        /**
         * 对比版本号，如果当前版本大于客户端版本则更新
         * 0不更新 1更新 2强制更新
         */
        if ($version->version > $this->headers['version']) {
            //根据是否强制更新，进行赋值
            $version->is_update = $version->is_force == 1 ? 2 : 1;
        } else {
            $version->is_update = 0;
        }

        // 记录用户的基本信息 用于统计
        $actives = [
            'version' => $this->headers['version'],
            'app_type' => $this->headers['app_type'],
            'did' => $this->headers['did'],
            'model' => $this->headers['model'],
            'version_code' => $this->headers['version_code'],
        ];

        try {
            model('AppActive')->add($actives);
        }catch (\Exception $e) {
            Log::write($e->getMessage());
        }
        return apiReturn(config('code.success'), 'OK', $version, 200);
    }
}