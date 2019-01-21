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
    public $model = 'ArticleComment';

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

            //当什么都不搜索时，也就是直接加载评论管理首页时，也就是加载所有评论时
            if(empty($data['identity'])) $data['identity']='commentator';
            
            $comments = model('ArticleComment')->getComment($data['identity'], $whereData);
            return $this->fetch('',['comments'=>$comments,'page'=>$comments->render()]); 
        }
    }
}
