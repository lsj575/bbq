<?php
namespace app\index\controller;

use think\Request;
use app\index\model\User;


class UserController extends BaseController
{
//    private $avatarURL = 'http://127.0.0.1/gitlab/bbq/public/static/uploads/user_avatar/';
//    private $homeImgURL = 'http://127.0.0.1/gitlab/bbq/public/static/uploads/home_img/';
    private $avatarURL = 'http://bbq.wutnews.net/bbq/public/static/uploads/user_avatar/';
    private $homeImgURL = 'http://bbq.wutnews.net/bbq/public/static/uploads/home_img/';

    public function getUserInfo()
    {
        $code = parent::checkToken();

        if ($code == 10100) {
            return apireturn(10100, "User is not logged in.", null, 200);
        } elseif ($code == 10101) {
            return apireturn(10101, "Landing expired.", null, 200);
        } elseif ($code == 10102) {
            return apireturn(10102, "Invalid login token.", null, 200);
        }

        $postData = Request::instance()->post();

        $user = new User();
        $res = $user->findOneUserById($code);

        if (is_null($res['data'])) {
            return apireturn($res['code'], $res['msg'], null, 200);
        } else {
            unset($res['data']['token']);
            $res['data']['avatar'] = str_replace('\\', '/', $res['data']['avatar']);
            $res['data']['home_img'] = str_replace('\\', '/', $res['data']['home_img']);
            $res['data']['avatar'] = $this->avatarURL . $res['data']['avatar'];
            $res['data']['home_img'] = $this->homeImgURL . $res['data']['home_img'];
            return apireturn($res['code'], $res['msg'], $res['data'], 200);
        }
    }

    public function changeUserNickname()
    {
        $code = parent::checkToken();

        if ($code == 10100) {
            return apireturn(10100, "User is not logged in.", null, 200);
        } elseif ($code == 10101) {
            return apireturn(10101, "Landing expired.", null, 200);
        } elseif ($code == 10102) {
            return apireturn(10102, "Invalid login token.", null, 200);
        }
        $postData = Request::instance()->post();

        $user = new User();

        $res = $user->changeUserNicknameById($code, $postData['nickname']);

        if ($res['code'] == 0) {
            return apireturn(0, "Update user nickname success.", null, 200);
        } else {
            return apireturn($res['code'], "Failed to update user nickname.", null, 200);
        }
    }

    public function changeUserIntroduction()
    {
        $code = parent::checkToken();

        if ($code == 10100) {
            return apireturn(10100, "User is not logged in.", null, 200);
        } elseif ($code == 10101) {
            return apireturn(10101, "Landing expired.", null, 200);
        } elseif ($code == 10102) {
            return apireturn(10102, "Invalid login token.", null, 200);
        }
        $postData = Request::instance()->post();

        $user = new User();

        $res = $user->changeUserIntroductionById($code, $postData['introduction']);

        return apireturn($res['code'], $res['msg'], null, 200);
    }

    public function uploadUserAvatar()
    {
        $code = parent::checkToken();

        if ($code == 10100) {
            return apireturn(10100, "User is not logged in.", null, 200);
        } elseif ($code == 10101) {
            return apireturn(10101, "Landing expired.", null, 200);
        } elseif ($code == 10102) {
            return apireturn(10102, "Invalid login token.", null, 200);
        }

        $file = request()->file('avatar');
        if ($file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . DS . 'public' . DS . 'static' . DS  . 'uploads'. DS . 'user_avatar', true, false);
            if($info){
                $savaName = $info->getSaveName();

                $user = new User();
                $res = $user->uploadUserAvatar($code, $savaName);
                return apireturn($res['code'], $res['msg'], null, 200);
            }else{
                // 上传失败获取错误信息
                return apireturn(20001, 'Picture upload failed', null, 200);
            }
        }
    }

    public function uploadUserHomeImg()
    {
        $code = parent::checkToken();

        if ($code == 10100) {
            return apireturn(10100, "User is not logged in.", null, 200);
        } elseif ($code == 10101) {
            return apireturn(10101, "Landing expired.", null, 200);
        } elseif ($code == 10102) {
            return apireturn(10102, "Invalid login token.", null, 200);
        }

        $file = request()->file('home_img');
        if ($file){
            $info = $file->move(ROOT_PATH . DS . 'public' . DS . 'static' . DS . 'uploads'. DS . 'home_img', true, false);
            if($info){
                $savaName = $info->getSaveName();

                $user = new User();
                $res = $user->uploadUserHomeImg($code, $savaName);
                return apireturn($res['code'], $res['msg'], null, 200);
            }else{
                // 上传失败获取错误信息
                return apireturn(20001, 'Picture upload failed', null, 200);
            }
        }
    }
}