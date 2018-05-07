<?php
namespace app\index\controller;

use think\Request;
use app\index\model\User;


class UserController extends BaseController
{
    public function getUserInfo()
    {
        $code = parent::checkToken();

        if ($code == 10010) {
            return apireturn(10010, "User is not logged in.", null, 200);
        } elseif ($code == 10011) {
            return apireturn(10011, "Landing expired.", null, 200);
        } elseif ($code == 10012) {
            return apireturn(10012, "Invalid login token.", null, 200);
        }

        $postData = Request::instance()->post();

        $user = new User();
        $res = $user->findOneUserById($postData['id']);

        if (is_null($res)) {
            return apireturn($res['code'], $res['msg'], null, 200);
        } else {
            unset($res['data']['token']);
            return apireturn($res['code'], $res['msg'], $res['data'], 200);
        }
    }
}