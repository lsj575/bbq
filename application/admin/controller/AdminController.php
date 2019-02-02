<?php
namespace app\admin\controller;

use think\Controller;
use app\common\lib\IAuth;

class AdminController extends  BaseController
{
    public $model = 'AdminUser';

    public function index(){
        if(request()->isGet()){
            $data = input('get.');

            $results = model('AdminUser')->getUser($data);

            $this->assign('results',$results);
        }

        return $this->fetch();
    }
    public function add()
    {
        //判断是否是post提交
        if (request()->isPost()) {
            $data = input('post.');
            // validate 。 其实前端已经判断过一次了
            $validate = validate('AdminUser');
            if (!$validate->check($data)) {
                return $this->result('',config('code.FAILURE'),$validate->getError());
            }

            //加密、加盐
            $data['password'] = IAuth::setPassword($data['password']);
            $data['status'] = 1;
            try {
                $id = model('AdminUser')->add($data);
            }catch (\Exception $e) {
                return $this->result('',config('code.FAILURE'),'保存失败');
            }

            if ($id) {
                return $this->result(['jump_url' => url('admin/admin/index')],config('code.SUCCESS'),'OK');
            }else {
                return $this->result('',config('code.FAILURE'),'保存失败');
                $this->error('error');
            }
        }else {
            $this->assign('roles',model('AdminRole')::all());
        }
        return $this->fetch();
    }
}
