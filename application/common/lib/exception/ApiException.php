<?php
namespace app\common\lib\exception;

use think\Exception;

class ApiException extends Exception
{
    public $message = '';
    public $httpCode = 500;
    public $code = 0;
    /**
     * ApiException constructor.
     * @param string $message
     * @param int $httpCode
     * @param int $code
     */
    public function __construct($message = '', $httpCode = 0, $code = 0)
    {
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;
    }
}