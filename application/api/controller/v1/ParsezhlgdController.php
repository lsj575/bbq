<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/20
 * Time: 9:13 AM
 */
namespace app\api\controller\v1;

use app\api\controller\CommonController;

class ParsezhlgdController extends CommonController
{
    /**
     * 解析zhlgd首页获取lt和post值
     * @return \json
     */
    public function parseIndex()
    {
        $url = 'http://zhlgd.whut.edu.cn';
        try {
            $html = file_get_html($url);
        } catch (\Exception $e) {
            return apiReturn(config('code.FAILURE'), $e->getMessage(), '', 500);
        }

        $lt = $html->find('input[id=lt]', 0)->value;
        $postUrl =  $html->find('form[id=loginForm]', 0)->action;
        $data = [
            'lt'        => $lt,
            'postUrl'   => $postUrl,
        ];
        return apiReturn(config('code.SUCCESS'), 'ok', $data, 200);
    }
}

