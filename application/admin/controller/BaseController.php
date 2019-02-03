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

        $user = session(config('admin.session_user'), '',config('admin.session_user_scope'));
        if( ! model("AdminRole")->havePermission($user->id, request()->controller(), request()->action())){
            exit('您没有此操作权限');
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
            $this->assign('admin_role_name',session('admin_role_name','',config('admin.session_user_scope')));
            return true;
        }
        return false;
    }
    
    public function delete($id = 0)
    {
        if(!intval($id)) {
            return $this->result('', config('code.FAILURE'), 'ID不合法');
        }
        $model = $this->model ? $this->model : request()->controller();
        try {
            //通过id查询记录是否存在
            $res1 = model($model)->get($id);
            if (!$res1) {
                return $this->result('', config('code.FAILURE'), '没有此条记录！');
            }else {
                $res2 = model($model)->save(['status' => -1], ['id' => $id]);

            }

        }catch(\Exception $e){
            return $this->result('', config('code.FAILURE'), $e->getMessage());
        }
    
        if($res2) {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], config('code.SUCCESS'), 'OK');
        }else {
            return $this->result('', config('code.FAILURE'), '删除失败!');
        }
    }

    /**
     * 通用化修改状态
     */
    public function status()
    {
        $data = input('param.');
        // 数据需要做校验
        $validate = validate('Base');
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $model = $this->model ? $this->model : request()->controller();
        try {
            //通过id查询记录是否存在
            $res1 = model($model)->get($data['id']);
            if (!$res1) {
                return $this->result('', config('code.FAILURE'), '没有此条记录！');
            }else {
                $res2 = model($model)->save(['status' => $data['status']], ['id' => $data['id']]);
            }

        }catch(\Exception $e){
            return $this->result('', config('code.FAILURE'), $e->getMessage());
        }

        if($res2) {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], config('code.SUCCESS'), 'OK');
        }else {
            return $this->result('', config('code.FAILURE'), '删除失败!');
        }
    }
}
