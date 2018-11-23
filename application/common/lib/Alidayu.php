<?php
/**
 * Created by PhpStorm.
 * User: 76871
 * Date: 2018/11/12
 * Time: 22:30
 */
namespace app\common\lib;
use app\common\lib\alidayu\SignatureHelper;
use think\Cache;
use think\Exception;
use think\Log;

/**
 * 阿里发送短信基础类库
 * Class Alidayu
 * @package app\common\lib
 */
class Alidayu
{
    const LOG_TPL = "alidayu:";
    /**
     * 静态变量保存全局实例
     * @var null
     */
    private static $_instance = null;

    /**
     * 私有构造方法
     * Alidayu constructor.
     */
    private function __construct()
    {
    }

    /**
     * 静态方法 单例模式统一入口
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 设置短信验证
     * @param int $phone
     * @return bool
     */
    public function setSmsIdentify($phone = 0)
    {
        Log::write(self::LOG_TPL . "sendSms-start----");
        $params = array ();
        /**
         * 生成验证码随机数
         */
        $code = rand(1000, 9999);
        // *** 需用户填写部分 ***
        // fixme 必填：是否启用https
        $security = false;

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = config('aliyun.accessKeyId');
        $accessKeySecret = config('aliyun.accessKeySecret');

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $phone;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = config('aliyun.signName');

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = config('aliyun.templateCode');

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => $code,
        );

        // fixme 可选: 设置发送短信流水号
        // $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        // $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        try {
            // 此处可能会抛出异常，注意catch
            $content = $helper->request(
                $accessKeyId,
                $accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($params, array(
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                )),
                $security
            );
        } catch (\Exception $e) {
            // 记录日志
            Log::write(self::LOG_TPL . "set----" . $e->getMessage());
            return false;
        }

        if ($content->Code == 'OK') {
            // 设置验证码失效时间
            Cache::set($phone, $code, config('aliyun.identify_time'));
            return true;
        }
        Log::write(self::LOG_TPL . "set----" . json_encode($content));

        return false;
    }

    /**
     * 根据手机号码查询验证码是否正常
     * @param int $phone
     * @return bool
     */
    public function checkSmsIdentify($phone = 0)
    {
        if (!$phone) {
            return false;
        }

        return Cache::get($phone);
    }
}