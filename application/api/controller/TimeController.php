<?php
namespace app\api\controller;

use think\Controller;

class TimeController extends Controller
{
    /**
     * 获取服务器时间，保证客户端与服务端时间一致性
     * @return \json|\think\response\Json
     */
    public function index()
    {
        return apiReturn(1, 'OK', time());
    }
}