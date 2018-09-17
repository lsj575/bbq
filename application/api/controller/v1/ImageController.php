<?php
/**
 * Created by PhpStorm.
 * User: sijie.long
 * Date: 2018/8/17
 * Time: 9:39
 */

namespace app\api\controller\v1;

use app\common\lib\Aes;
use think\Controller;

class ImageController extends AuthBaseController
{
    /**
     * BBQ项目专属appcode，由64位小写字母组成
     * @var string
     */
    private $appCode = 'rjktdkjwgvkexmoujqaegficgcetscofgucldvqzwpxwwdfsxndpovuuvqethbwx';

    /**
     * 生成上传图片所需的accessToken
     * 由AppCode前32位数+时间戳去掉最后四位数+AppCode后32位数+随机Nonce+token123组成
     * @return string
     */
    public function getAccessToken()
    {
        $nonce = $this->createNonce(16);
        $time = time() % 10000;
        $appCodeArray = str_split($this->appCode, 32);
        $accessToken = md5($appCodeArray[0] . $time . $appCodeArray[1] . $nonce . 'token123');
        return apiReturn(config('code.app_show_success'), 'OK', $accessToken);
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