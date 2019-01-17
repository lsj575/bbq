<?php
/**
 * Created by PhpStorm.
 * User: Junhao
 * Date: 2018/12/14
 * Time: 21:26
 */

namespace app\admin\controller;

use app\common\model\ArticleComment;
use think\Controller;
use app\common\lib\IAuth;
class CommentController extends BaseController
{
    public $model="ArticleComment";
    public function index(){
        if(request()->isGet()){
            $data = input('get.');
            //有搜索内容时时执行
            if(!empty($data["thetext"]) && $data["thetext"]!=""){
                if($data["condition"]=="content"){//按内容搜索
                    $comments = model("ArticleComment")->where("content","like","%".$data["thetext"]."%")->paginate(5);
                    $this->assign("page",$comments->render());
                }else if($data["condition"]=="commentator"){//按评论者
                    $comments = model("User")
                        ->alias('u')
                        ->join('article_comment m','u.id = m.user_id')
                        ->where('nickname','like','%'.$data['thetext'].'%')
                        ->paginate(5);
                    $this->assign("page",$comments->render());
                }else{//按被评论者
                    $comments = model("User")
                        ->alias('u')
                        ->join('article_comment m','u.id = m.to_user_id')
                        ->where('nickname','like','%'.$data['thetext'].'%')
                        ->paginate(5);
                    $this->assign("page",$comments->render());
                }
            }else{//当没有搜索内容时执行
                $comments = model("ArticleComment")::paginate(5);
                //这里的分页是tp框架自带的
                $this->assign("page",$comments->render());
            }
            if(count($comments)){
                foreach($comments as $comment){
                    $comment["user_id"]=model("User")::get($comment->user_id)->nickname;
                    $comment["to_user_id"]=model("User")::get($comment->to_user_id)->nickname;
                }
            } 
            $this->assign("comments",$comments);
        }
        return $this->fetch();
    }
}
