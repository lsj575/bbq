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
          $users = model("User")->where("nickname","like","%".$data["thetext"]."%")->select();
          $comments=array();
          foreach($users as $user){
            $comments = $comments + model("ArticleComment")->where("user_id","=",$user->id)->select();
          }

          $size  = count($comments);
          $start = empty($data["start"])? 0:$data["start"];
          $comments = array_slice($comments,$start,5);

          //ini_infor记录本次请求参数。
          $ini_infor=["now_i"=>$start,"size"=>$size,"thetext"=>$data["thetext"],"condition"=>$data["condition"]];
          $this->assign("ini_infor",$ini_infor);
        }else{//按被评论者
          $users = model("User")->where("nickname","like","%".$data["thetext"]."%")->select();
          $comments =array();
          foreach($users as $user){
            $comments = $comments + model("ArticleComment")->where("to_user_id","=",$user->id)->select();
          }

          $size = count($comments);
          $start = empty($data["start"])? 0:$data["start"];
          $comments = array_slice($comments,$start,5);

          //ini_infor记录本次请求信息。
          $ini_infor=["now_i"=>$start,"size"=>$size,"thetext"=>$data["thetext"],"condition"=>$data["condition"]];
          $this->assign("ini_infor",$ini_infor);

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
