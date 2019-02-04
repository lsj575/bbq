<?php
namespace app\admin\controller;


//用户动态管理
class ArticleController extends BaseController {
    //获取动态列表
    public function index(){
        if(request()->isGet()){
            $data = input('get.');

            $results = model('Article')->getArticleForAdmin($data);

            return $this->fetch('',[
                'results'       => $results,
                'start_time'    => empty($data['start_time']) ? '' : $data['start_time'],
                'end_time'      => empty($dta['end_time'])    ? '' : $data['end_time'],
            ]);
        }

    }
}
