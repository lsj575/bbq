<?php
namespace app\index\controller;

use app\index\model\Member;
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
        if(!$info) exit('授权被拒绝');

        Session::set('user', $info['cardNo']);

        $return = $this->login();

        return apireturn($return['code'], $return['msg'], $return['data'], 200);

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

        Session::set('user.cardno', $info['cardno']);
        $return = $this->login();

        return apireturn($return['code'], $return['msg'], $return['data'], 200);
    }

    public function login()
    {
        $user = new Member();

        $member = $user->FindOneUser(Session::get('user.cardno'));
        if(is_null($member['data'])) {
            $res = $user->InsertOneUser($info);
            if ($res['code'] == 0) {
                $userinfo = $user->FindOneUser(Session::get('user.cardno'));
                Session::set('user.id', $userinfo['id']);
            }
            return $res;
        } else {
            $res = $user->UpdateLoginTime($member['data']['id'], $member['data']['login']);
            Session::set('user.id', $member['id']);
            return $res;
        }
    }

    public function deleteSession()
    {
        Session::delete('user');
    }
}