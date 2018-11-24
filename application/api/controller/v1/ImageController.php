<?php
/**
 * Created by PhpStorm.
 * User: sijie.long
 * Date: 2018/8/17
 * Time: 9:39
 */

namespace app\api\controller\v1;

use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use think\Cache;
use think\Controller;

/**
 * Class ImageController
 * 图片上传控制器，只负责接口所需的参数获取，例如access_token
 * 图片存储交由团队统一静态资源文件接口处理，URL：https://github.com/TokenTeam/Token-Static-Center/blob/master/README.md
 * @package app\api\controller\v1
 */
class ImageController extends AuthBaseController
{

    /**
     * accessToken缓存过期时间
     * @var int 3分钟
     */
    private $accessTokenCacheTimeOut = 180;

    /**
     * 生成上传图片所需的accessToken
     * 由AppCode前32位数+时间戳去掉最后四位数+AppCode后32位数+随机Nonce+token123组成
     * @return \json|\think\response\Json
     * @throws ApiException
     */
    public function getAccessToken()
    {
        // 查询缓存中是否存在该用户已被禁止三分钟内请求accessToken
        if (Cache::get("$this->user->id . 'accesstoken'"))
        {
            // 被禁止后，每次请求缓存值加一
            Cache::inc("$this->user->id . 'accesstoken'");
            return apiReturn(config('code.app_show_error'), '请求过于频繁，请三分钟后重试', '', 403);
        }
        // 查询数据库中的该用户请求次数
        try {
            $logCount = model('AccesstokenLog')->where('user_id', $this->user->id)
                ->where('create_time', ['>', time()-60])
                ->count();
        } catch (\Exception $e) {
            return apiReturn(config('code.app_show_error'), '数据库查询错误', '', 500);
        }
        // 若一分钟之内超过十次则提醒其等三分钟
        if ($logCount >= 10)
        {
            // 将用户信息加入缓存中，禁止短时间内访问
            Cache::set("$this->user->id . 'accesstoken'", 0, $this->accessTokenCacheTimeOut);
            return apiReturn(config('code.app_show_error'), '请求过于频繁，请三分钟后重试', '', 403);
        }

        // 开始生成accessToken
        $nonce = $this->createNonce(16);
        $time = substr(time(), 0, 6);
        $appCodeArray = str_split(config('code.APP_CODE'), 32);

        $accessToken = md5($appCodeArray[0] . $time . $appCodeArray[1] . $nonce . 'token_bbq_0nwzNE5V');

        $data = [
            'user_id'     => $this->user->id,
            'source_type' => 0,
            'accesstoken' => $accessToken,
        ];

        //入库操作
        try {
            $id =  model('AccesstokenLog')->add($data);
        }catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($id) {
            return apiReturn(config('code.app_show_success'), 'ok', $accessToken, 200);
        }else {
            return apiReturn(config('code.app_show_error'), '获取失败', '', 500);
        }
    }

    /**
     * 生成随机nonce
     * @param int $nonceLength
     * @return string
     */
    private function createNonce($nonceLength = 16)
    {
        $nonce = '';
        for ($i = 0; $i < $nonceLength; $i++)
        {
            $nonce .= chr(mt_rand(97, 122));
        }
        return $nonce;
    }
}