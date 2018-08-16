<?php
namespace app\api\controller\v1;

use app\api\controller\CommonController;

class IndexController extends CommonController
{
    public function index()
    {
        try {
            $header = model('Article')->getIndexHeadNormalArticle();
            $positions = model('Article')->getPositionNormalArticle();
            $likes = model('Article')->getLikesNormalArticle();
        }catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }
}