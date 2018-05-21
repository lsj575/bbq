<?php
namespace app\index\controller;

use app\index\model\Article;
use think\Request;

class ArticleController extends BaseController
{
    public function addArticle()
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
        $imgs = Request::instance()->file('images');
        $article = new Article();
        $article->startTrans();
        $res = $article->addArticle($postData, $imgs);
        if ($res['code'] == 0 && isset($imgs) && !is_null($imgs)) {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $imgs->validate(['size'=>8388608,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . DS . 'public' . DS . 'static' . DS . 'uploads' . DS . 'article_img', true, false);
            if ($info) {
                return apireturn($res['code'], $res['msg'], $res['data'], 200);
            } else {
                $article->rollback();
                return apireturn(20001, 'Picture upload failed', null, 200);
            }
        }
        return apireturn($res['code'], $res['msg'], $res['data'], 200);
    }
}