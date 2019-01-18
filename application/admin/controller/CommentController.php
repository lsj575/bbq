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
    public function index(){
        if(request()->isGet()){
            $this->model = 'ArticleComment';
            $data = input('get.');

            $whereData = [];
            if(!empty($data['content'])){
                $whereData['content'] = ['like',"%".$data['content']."%"];
            }
            if(!empty($data['nickname'])){
                $whereData['nickname'] = ['like',"%".$data['nickname']."%"];
            }
            if(empty($data['identity'])) $data['identity']='commentator';
            
            $comments = model('ArticleComment')->getComment($whereData,$data['identity']);
            return $this->fetch('',['comments'=>$comments,'page'=>$comments->render()]); 
        }
    }
}
