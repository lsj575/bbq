<?php
namespace app\common\lib;

use think\Cache;

class IAuth
{
    /**
     * 设置密码
     * @param string $data
     * @return string
     */
    public static function setPassword($data)
    {
        return md5($data.config('app.password_pre_halt'));
    }

    /**
     * 生成每次请求的sign
     * @param array $data
     * @return HexString|string
     */
    public static function setSign($data = [])
    {
        //1 按字段排序
        ksort($data);
        //2 拼接字符串数据
        $string = http_build_query($data);
        //3 通过aes加密
        $string = (new Aes())->encrypt($string);
//        //4 所有字符转化大写
//        $string = strtoupper($string);

        return $string;
    }

    /**
     * 检查sign是否正常
     * @param $data
     * @return boolean
     */
    public static function checkSignPass($data)
    {
        $str = (new Aes())->decrypt($data['sign']);

        if (empty($str)) {
            return false;
        }

        parse_str($str, $arr);
        //检查设备号did
        if (!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']) {
            return false;
        }

        // 如果打开debug模式，则不对时间做校验
        if (!config('app_debug')) {
            //Java or JavaScript的时间戳位数为13位，PHP为10位，所以需要做转换
            if ((time() - ceil($arr['time'] / 1000)) > config('app.sign_time')) {
                return false;
            }

            // 唯一性判断
            if (Cache::get($data['sign'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * 设置登录的token - 唯一
     * @param string $phone
     * @return string
     */
    public static function setAppLoginToken($phone = '')
    {
        $str = md5(uniqid(md5(microtime(true)), true));
        $str = sha1($str.$phone);
        return $str;
    }

    /**
     * 检查access_user_token是否正常
     * @param $access_user_token
     * @return boolean
     */
    public static function checkAccessUserTokenPass($access_user_token)
    {
        if (empty($access_user_token)) {
            return false;
        }

        //如果没有两个|| ，则也不成立
        if (!preg_match('/||/', $access_user_token)) {
            return false;
        }
        list($token, $time) = explode("||", $access_user_token);

        //如果开了调试模式则不验证access_user_token的时间
        if (!config('app_debug')) {
            //Java or JavaScript的时间戳位数为13位，PHP为10位，所以需要做转换
            if ((time() - ceil($time / 1000)) > config('app.access_user_token_time')) {
                return false;
            }

            // 唯一性判断
            if (Cache::get($access_user_token)) {
                return false;
            }
        }

        return true;
    }
}