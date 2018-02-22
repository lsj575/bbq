<?php
namespace app\index\controller;

use think\Controller;
use think\Session;

class LoginController extends Controller
{
    public function index()
    {
        var_dump(Session::get('user'));
    }

    public function msign()
    {
        $info = json_decode(urldecode($_SERVER['HTTP_M_SIGN']), true);

        Session::set('user', $info['cardNo']);
    }

    private function check($info)
    {
        $cardno = $info['cardno'];
        $appkey = $info['sign']['appKey'];
        $timestamp = $info['sign']['timestamp'];
        $nonce = $info['sign']['nonce'];
        $token = $info['sign']['token'];
        $openid = md5($appkey.$cardno);
        if($openid != $token) return false;
        $check = md5($nonce.$openid.$timestamp);
        return $check == $info['sign']['check'];
    }

    public function ias()
    {
        $info = json_decode($_POST['user'], true);
        if(!$info || empty($info['cardno'])) exit('授权被拒绝');
        var_dump($info);
    }
}