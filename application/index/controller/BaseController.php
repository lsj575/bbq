<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\LoginController;
use think\Request;
use think\Session;
use app\index\model\User;

class BaseController extends Controller
{
    public function index()
    {
        var_dump(Session::get('a'));
    }

    public function checkToken()
    {
        if (isset($_SERVER['HTTP_M_SIGN'])) {
            $login = new LoginController();
            $res = $login->msign();
            $this->redirect('http://test.wutnews.net/lsj/bbq/public/index/login/index');
        } elseif (isset($_SERVER['HTTP_BSIGN'])){
            if ($_SERVER['HTTP_BSIGN'] == 'APP') {
                $postData = Request::instance()->post('token');
                $token = base64_decode($postData);
                $data = explode("|", $token);

                $user = new User();
                $res = $user->findOneUserById($data[0]);

                if ($data[2] + 8640000 < time()) {
                    return 10101;
                } elseif ($res['data']['token'] != $postData) {
                    return 10102;
                } else {
                    return $data[0];
                }
            } elseif ($_SERVER['HTTP_BSIGN'] == 'WEB') {
                if (is_null(Session::get('user.id'))) {
                    return 10100;
                } else {
                    return Session::get('user.id');
                }
            }
        } else {
            return 10010;
        }

    }

}
