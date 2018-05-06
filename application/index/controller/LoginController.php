<?php
namespace app\index\controller;

use app\index\model\User;
use think\Controller;
use think\Request;
use think\Session;

class LoginController extends Controller
{
    private static $key = 'tokencoursetable';
    private static $iv = 'TOKEN123token123';

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

        $isLogin = $this->checkIsLogin($postData);
        if ($isLogin) {
            $user = new User();

            $theUser = $user->findOneUserByCardno($postData['cardno']);
            if(is_null($theUser['data'])) {
                $sessionID = session_id();
                $time = time();
                $token = json_encode($theUser['data']['id']) . '|' .$sessionID . '|' . $time;
                $postData['token'] = base64_encode($token);
                $res = $user->insertOneUser($postData);
                if ($res['code'] == 0) {
                    $userinfo = $user->findOneUserByCardno($postData['cardno']);
                    $this->setSession($userinfo['data']);


                    $userinfo['data']['token'] = base64_encode($token);
                    return apireturn($userinfo['code'], $userinfo['msg'], $userinfo['data'], 200);
                } else {
                    return apireturn($res['code'], $res['msg'], null, 500);
                }

            } else {
                $this->setSession($theUser['data']);

                $sessionID = session_id();
                $time = time();
                $token = json_encode($theUser['data']['id']) . '|' .$sessionID . '|' . $time;
                $theUser['data']['token'] = base64_encode($token);
                $res = $user->updateLogin($theUser['data']['id'], $theUser['data']['token']);

                return apireturn($theUser['code'], $theUser['msg'], $theUser['data'], 200);
            }
        } else {
            return apireturn(10004, "Login verification failed", null, 200);
        }


    }

    public function checkIsLogin($data) {
        $verify = base64_decode($data['verify']);
        $verification = explode("|", $verify);
        $sno = self::decrypt($verification[1]);
        if ($data['cardno'] == $verification[0] && $data['sno'] == $sno) {
            return true;
        } else {
            return false;
        }
    }

    public static function encrypt($str) {
        $str = $str.str_repeat("\0", 16 - strlen($str) % 16);
        $encrypt = openssl_encrypt($str, 'AES-128-CBC', self::$key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, self::$iv);

        return bin2hex($encrypt);
    }

    public static function decrypt($str) {
        $decrypt = openssl_decrypt(hex2bin($str), 'AES-128-CBC', self::$key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, self::$iv);
        return rtrim($decrypt, "\0");
    }

    public function setSession($data)
    {
        Session::set('user.id', $data['id']);
    }

    public function deleteSession()
    {
        Session::delete('user');
    }
}