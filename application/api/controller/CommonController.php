<?php
namespace app\api\controller;

use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use think\Cache;
use think\Controller;

/**
 * API模块 公共的控制器
 * Class Common
 * @package app\api\controller
 */
class CommonController extends Controller
{
    /**
     * headers信息
     * @var string
     */
    public $headers = '';
    /**
     * 初始化方法
     */
    public function _initialize()
    {
        $this->checkRequestAuth();
    }

    /**
     * 检查每次app请求的数据是否合法
     */
    public function checkRequestAuth()
    {
        //首先需要获取headers
        $headers = request()->header();

        //sign 加密需要客户端工程师
        //1 headers body 仿照sign做参数加密

        //基础参数校验
        if (empty($headers['sign'])) {
            throw new ApiException('sign不存在', 400);
        }

        if (!in_array($headers['app_type'], config('app.app_types'))) {
            throw new ApiException('app type 不合法', 400);
        }

        if (IAuth::checkSignPass($headers)) {
            throw new ApiException('授权码sign失败', 401);
        }

        Cache::set($headers['sign'], 1, config('app.sign_cache_time'));
        $this->headers = $headers;

    }


    //TODO 完成对文章数据的处理
    protected function getDealArticle($article = [])
    {
        if (empty($article)) {
            return [];
        }

        $themes = 1;
    }
}