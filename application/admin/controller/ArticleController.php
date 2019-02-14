<?php
namespace app\admin\controller;

use think\Controller;

//暂时先不鉴权，方便前端调试
//动态管理
class ArticleController extends BaseController{

    public function index(){
        if (request()->isGet()) {
            $data = input('get.');

            $results = model('Article')->getArticleForAdmin($data);

            return $this->fetch('',['results'=>$results]);
        }
    }

    //动态的隐藏、显示。 推荐、置顶状态的更替。
    public function convert() {
        if (request()->isPost() ) {
            $data = input('post.');

            if ((!empty($data['id'])) && (!empty($data['type']))) {
                try {
                    $article = model('Article')->get($data['id']);
                    
                    if ($data['type']=='hide') {
                        if ($article->status==-1) $article->status = '1';
                        else $article->status = '-1';

                    }else if($data['type']=='recommend') {
                        $article->is_position = !$article->is_position;
                    }else {
                        $article->is_sticky = !$article->is_sticky;
                    }

                    $article->save();

                    return json_encode(['status'=>200],JSON_UNESCAPED_SLASHES);
                }catch (\Exception $e) {
                    return json_encode(['status'=>400,'message'=>$e->getMessage()],JSON_UNESCAPED_SLASHES);
                }
            }
        }
    }

}
