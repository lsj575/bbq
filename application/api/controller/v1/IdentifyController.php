<?php
namespace app\api\controller\v1;

use app\common\lib\Alidayu;
use app\common\lib\exception\ApiException;
use app\api\controller\CommonController;

class IdentifyController extends CommonController
{
    public function save()
    {
        if (!request()->isPost()) {
            return apiReturn(config('code.app_show_error'), '您提交的数据不合法', [], 403);
        }

        // 校验数据
        $validate = validate('Identify');
        if (!$validate->check(input('post.'))) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), [], 403);
        }

        //
        $id = input('param.id');
        if (Alidayu::getInstance()->setSmsIdentify($id)) {
            return apiReturn(config('code.app_show_success'), 'OK', [], 201);
        } else {
            return apiReturn(config('code.app_show_error'), '发送短信失败', [], 500);
        }
    }
}