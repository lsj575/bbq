<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

/**
 * Class ImageController
 * @package app\admin\controller
 * 后台图片上传逻辑
 */
class ImageController extends BaseController
{
    /**
     * accessToken缓存过期时间
     * @var int 3分钟
     */
    private $accessTokenCacheTimeOut = 150;

    /**
     * 生成上传图片所需的accessToken
     * 由AppCode前32位数+时间戳去掉最后四位数+AppCode后32位数+随机Nonce+token123组成
     * @return string
     */
    public function getAccessToken()
    {
        if (request()->isGet()) {
            // 获取session
            $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));
            // 查询缓存中是否存在该用户已被禁止三分钟内请求accessToken
            if (Cache::get($user->id . 'accesstoken'))
            {
                // 被禁止后，每次请求缓存值加一
                Cache::inc($user->id . 'accesstoken');
                return $this->result('', config('code.FAILURE'), '请三分钟后重试');
            }

            // 查询数据库中的该用户请求次数
            try {
                $logCount = model('AccesstokenLog')->where('user_id', $this->user->id)
                    ->where('create_time', ['>', time()-60])
                    ->count();
            } catch (\Exception $e) {
                return $this->result('', config('code.FAILURE'), '数据库错误，请联系技术人员');
            }

            // 若一分钟之内超过十次则提醒其等三分钟
            if ($logCount >= 10)
            {
                // 将用户信息加入缓存中，禁止短时间内访问
                Cache::set($user->id . 'accesstoken', 0, $this->accessTokenCacheTimeOut);
                return $this->result('', config('code.FAILURE'), '请三分钟后重试');
            }

            // 开始生成accessToken
            $nonce = $this->createNonce(16);
            $time = time() % 10000;
            $appCodeArray = str_split(config('code.app_code'), 32);
            $accessToken = md5($appCodeArray[0] . $time . $appCodeArray[1] . $nonce . 'token123');

            $data = [
                'user_id'     => $user->id,
                'source_type' => 0,
                'accesstoken' => $accessToken,
            ];

            //入库操作
            try {
                $id =  model('AccesstokenLog')->add($data);
            }catch (\Exception $e) {
                return $this->result('', config('code.FAILURE'), '新增数据失败，请重试或联系技术人员');
            }

            if ($id) {
                return $this->result($accessToken, config('code.SUCCESS'), '获取成功');
            }else {
                return $this->result('', config('code.FAILURE'), '获取数据失败');
            }
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