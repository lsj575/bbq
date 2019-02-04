<?php

namespace app\admin\controller;

use think\Controller;


//查看、编辑管理角色的权限。
class RightsController extends BaseController{
    //获取、修改特定角色的权限列表。
    public function index($roleid = 1){
        $data = [];

        //获取角色列表、权限列表
        $powers  = model('AdminPower')::all();
        $roles   = model('AdminRole')::all();
        $data['powers']=$powers;
        $data['roles']=$roles;

        //获取特定角色的权限列表
        foreach ($roles as $r){
            if($r->roleid == $roleid){
                $role = $r;
                break;
            }
        }
        $data['role'] = $role;

        //遍历每个行为 ，检查特定角色是否有权限
        $s  = '|'.$role->powerid.'|';
        foreach ($powers as $p){
            $r = $p->powerid;
            if (preg_match("/\|$r\|/",$s)){
                $p->checked='checked="checked"';
            }
            else $p->checked='';
        } 


        return view('index',$data);
    }

    //添加一条行为
    public function add(){
        if (request()->isPost()){
            $data = input('post.');

            $validate = validate('Rights');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            try {
                $id = model('AdminPower')->add($data);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            if ($id) {
                $this->success('id='.$id.'的行为新增成功');
            }else{
                $this->error('error');
            }
        }

        return $this->fetch();
    }

    //修改特定管理员的权限
    public function edit(){
        if (request()->isPost()){
            $powers = input('post.powers/a');
            $roleid = input('post.roleid');
            
            $powerid = join('|',$powers);
            
            try {
                model('AdminRole')->where('roleid',$roleid)->update(['powerid'=>$powerid]);


                //修改当前管理员的权限则需要更新sessoin中记录的当前管理员的权限
                $user = session(config('admin.session_user'),'',config('admin.session_user_scope'));

                if ($user->roleid == $roleid) {
                    session('powerid',"|".model('AdminRole')->get($roleid)->powerid."|",config('admin.session_user_scope'));
                }
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            $this->success('修改成功');
        }
    }
}
