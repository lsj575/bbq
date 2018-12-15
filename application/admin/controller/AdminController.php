<?php
namespace app\admin\controller;

use think\Controller;
use app\common\lib\IAuth;

class AdminController extends  BaseController
{
    public function add()
    {
        //判断是否是post提交
        if (request()->isPost()) {
            $data = input('post.');
            // validate
            $validate = validate('AdminUser');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            //加密、加盐
            $data['password'] = IAuth::setPassword($data['password']);
            $data['status'] = 1;

            try {
                $id = model('AdminUser')->add($data);
            }catch (\Exception $e) {
                $this->error($e->getMessage());
            }

            if ($id) {
                $this->success('id=' . $id . '的用户新增成功');
            }else {
                $this->error('error');
            }
        }else {

        }
        return $this->fetch();
    }
}