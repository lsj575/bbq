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
        if (!isset($_SESSION['grad_name'])){
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
            $url = 'http%3a%2f%2ftest.wutnews.net%2flsj%2fbbq%2fpublic%2findex%2flogin%2fias';
            $this->redirect('http://ias.sso.wutnews.net/portal.php?posturl='.$url.'&continueurl=' . $url);
        }

    }
}
