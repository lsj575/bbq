<?php
namespace app\admin\controller;

use think\Controller;

/**
 * Class BaseController
 * @package app\admin\controller
 * 基础类库
 */
class BaseController extends Controller
{
    /**
     * 定义model
     * @var string
     */
    public $model = '';
    /**
     * 初始化方法
     */
    public function _initialize()
    {
        $isLogin = $this->isLogin();
        if (!$isLogin) {
            return $this->redirect('login/index');
        }
    }

    /**
     * 判断是否登录
     * @return bool
     */
    public function isLogin()
    {
        //获取session
        $user = session(config('admin.session_user'), '',config('admin.session_user_scope'));
        if ($user && $user->id) {
            return true;
        }
        return false;
    }
    
    public function delete($id = 0)
    {
        if(!intval($id)) {
            return $this->result('', config('code.FAILURE'), 'ID不合法');
        }
        $model = $this->model ? $this->model :request()->controller();
        try {
            $res = model($model)->save(['status' => -1], ['id' => $id]);
        }catch(\Exception $e){
            return $this->result('', config('code.FAILURE'), $e->getMessage());
        }
    
        if($res) {
            return $this->result(['jump_url' => $_SERVER['HTTP REFERER']], config('code.SUCCESS'), 'OK');
        }else {
            return $this->result('', config('code.FAILURE'), '删除失败!');
        }
    }
}