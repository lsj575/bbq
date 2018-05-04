<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\LoginController;

class BaseController extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    protected function _initialize()
    {
        if (!isset($_SESSION['user'])){
            $this->login();
        }
    }

    protected function login()
    {
        if (isset($_SERVER['HTTP_M_SIGN'])) {
            $login = new LoginController();
            $res = $login->msign();
            $this->redirect('http://test.wutnews.net/lsj/bbq/public/index/login/index');
        } else {
            return apireturn(10010, "User is not logged in.", null, 200);
        }
    }
}
