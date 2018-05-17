<?php
namespace app\index\controller;

use app\index\model\Theme;
use think\Request;
use think\Session;

class ThemeController extends BaseController
{
    //private $themeBackgroudImgURL = 'http://127.0.0.1/gitlab/bbq/public/static/uploads/theme_img/';
    private $themeBackgroudImgURL = 'http://bbq.wutnews.net/bbq/public/static/uploads/theme_img/';

    public function addTheme()
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

        $file = Request::instance()->file('themeimg');
        if ($file) {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>8388608,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . DS . 'public' . DS . 'static' . DS . 'uploads' . DS . 'theme_img', true, false);
            if ($info) {
                $postData['userID'] = $code;
                $postData['path'] = $info->getSaveName();
                $theme = new Theme();
                $res = $theme->addTheme($postData);
                return apireturn($res['code'], $res['msg'], $res['data'], 200);
            } else {
                // 上传失败获取错误信息
                return apireturn(20001, 'Picture upload failed', null, 200);
            }
        }
    }

    public function findUserCreateThemeByUserId()
    {
        $code = parent::checkToken();

        if ($code == 10100) {
            return apireturn(10100, "User is not logged in.", null, 200);
        } elseif ($code == 10101) {
            return apireturn(10101, "Landing expired.", null, 200);
        } elseif ($code == 10102) {
            return apireturn(10102, "Invalid login token.", null, 200);
        }

        $theme = new Theme();
        $res = $theme->findThemeByUserId($code);

        if (is_null($res['data'])) {
            return apireturn($res['code'], $res['msg'], null, 200);
        } else {
            $res['data']['background_img'] = str_replace('\\', '/', $res['data']['background_img']);
            $res['data']['background_img'] = $this->themeBackgroudImgURL . $res['data']['background_img'];
            return apireturn($res['code'], $res['msg'], $res['data'], 200);
        }
    }

    //TODO 后期可能查询所有主题只需要theme_id,theme_name,theme_img等少量信息
    public function getAllTheme()
    {
        $code = parent::checkToken();

        if ($code == 10100) {
            return apireturn(10100, "User is not logged in.", null, 200);
        } elseif ($code == 10101) {
            return apireturn(10101, "Landing expired.", null, 200);
        } elseif ($code == 10102) {
            return apireturn(10102, "Invalid login token.", null, 200);
        }

        $theme = new Theme();
        $res = $theme->findAllTheme();

        if (is_null($res['data'])) {
            return apireturn($res['code'], $res['msg'], null, 200);
        } else {
            var_dump($res['data'][0]['theme_name']);
            foreach ($res['data'] as $key => $value) {
                $res['data'][$key]['background_img'] = str_replace('\\', '/', $res['data'][$key]['background_img']);
                $res['data'][$key]['background_img'] = $this->themeBackgroudImgURL . $res['data'][$key]['background_img'];
            }
            return apireturn($res['code'], $res['msg'], $res['data'], 200);
        }
    }
}