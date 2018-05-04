<?php
namespace app\index\controller;

use app\index\model\User;
use think\Controller;
use think\Request;
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

        $return = $this->zlLogin($info);

        return apireturn($return['code'], $return['msg'], $return['data'], 200);

    }


    public function ias()
    {
        $info = json_decode($_POST['user'], true);
        if(!$info || empty($info['cardno'])) exit('授权被拒绝');

        Session::set('user.cardno', $info['cardno']);
        $return = $this->login();

        return apireturn($return['code'], $return['msg'], $return['data'], 200);
    }

    public function zlLogin($info)
    {
        $user = new User();

        $theUser = $user->findOneUser(Session::get('user.cardno'));
        if(is_null($theUser['data'])) {
            $res = $user->insertOneUser($info);
            if ($res['code'] == 0) {
                $userinfo = $user->findOneUser(Session::get('user.cardno'));
                Session::set('user.id', $userinfo['id']);
            }
            return $res;
        } else {
            $res = $user->updateLoginTime($theUser['data']['id']);
            Session::set('user.id', $theUser['id']);
            return $res;
        }
    }

    public function appLogin()
    {
        $postData = Request::instance()->post();

        $user = new User();

        $theUser = $user->findOneUser($postData['cardno']);
        if(is_null($theUser['data'])) {
            $res = $user->insertOneUser($postData);
            if ($res['code'] == 0) {
                $userinfo = $user->findOneUser($postData['cardno']);
            }

            $this->setSession($userinfo['data']);
            $userinfo['data']['session_id'] = session_id();

            return apireturn($userinfo['code'], $userinfo['msg'], $userinfo['data'], 200);
        } else {
            $res = $user->updateLoginTime($theUser['data']['id']);

            $this->setSession($theUser['data']);
            $theUser['data']['session_id'] = session_id();

            return apireturn($theUser['code'], $theUser['msg'], $theUser['data'], 200);
        }
    }

    public function setSession($data)
    {
        Session::set('user.id', $data['id']);
        Session::set('user.cardno', $data['cardno']);
        Session::set('user.nickname', $data['nickname']);
    }

    public function deleteSession()
    {
        Session::delete('user');
    }
}