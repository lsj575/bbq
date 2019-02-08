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
            
            $comments = model('ArticleComment')->getComment($data);
            
            return $this->fetch('',['comments'=>$comments,'page'=>$comments->render()]); 
        }
    }
}
