<?php
namespace app\common\lib\exception;

use think\exception\Handle;

class ApiHandleException extends Handle
{
    /**
     * http状态码
     * @var int
     */
    public $httpCode = 500;

    /**
     * @param \Exception $e
     * @return \json|\think\Response|\think\response\Json
     */
    public function render(\Exception $e)
    {
        if (config('app_debug') == true) {
            return parent::render($e);
        }
        if ($e instanceof ApiException) {
            $this->httpCode = $e->httpCode;
        }
        return apiReturn(0, $e->getMessage(), [], $this->httpCode);
    }
}