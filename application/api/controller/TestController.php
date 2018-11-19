<?php
/**
 * Created by PhpStorm.
 * User: 76871
 * Date: 2018/11/5
 * Time: 11:05
 */
namespace app\api\controller;

use app\common\lib\Aes;
use think\Controller;

class TestController extends Controller
{
    public function encrypt()
    {
        $aes = new Aes();
        $encrypt = $aes->encrypt(input('str'));
        echo $encrypt;
    }

    public function decrypt()
    {
        $aes = new Aes();
        $decrypt = $aes->decrypt(input('str'));
        echo $decrypt;
    }
}