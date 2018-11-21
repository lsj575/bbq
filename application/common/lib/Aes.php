<?php
namespace app\common\lib;

/**
 * aes 加密 解密类库
 * Class Aes
 * @package app\common\lib
 */
class Aes {

    private $key = null;
    private $iv  = null;

    /**
     * Aes constructor.
     */
    public function __construct() {
        $this->key = config('app.aes_key');
        $this->iv  = config('app.aes_vi');
    }

    /**
     * 加密
     * @param string $str
     * @return string
     */
    public function encrypt($str = '') {
        $str = $str.str_repeat("\0", 16 - strlen($str) % 16);
        $encrypt = openssl_encrypt($str, 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);

        return bin2hex($encrypt);
    }
    /**
     * 填充方式 pkcs5
     * @param String text 		 原始字符串
     * @param String blocksize   加密长度
     * @return String
     */
    private function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * 解密
     * @param $sStr
     * @return string
     */
    public function decrypt($sStr) {
        $decrypted = openssl_decrypt(hex2bin($sStr), 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);

        return rtrim($decrypted, "\0");
    }

}