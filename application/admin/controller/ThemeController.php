<?php
namespace app\admin\controller;

use think\Controller;
use Think\Exception;

class ThemeController extends BaseController
{
    public function index()
    {
        return $this->fetch();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');

            // 数据需要做校验
            $validate = validate('Theme');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            // 获取session
            $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));
            // form表单key名转换
            (!isset($data['is_position']))? $data['is_position'] = 0: $data['is_position'] = 1;
            (!isset($data['is_head_figure']))? $data['is_head_figure'] = 0: $data['is_head_figure'] = 1;
            //TODO 将图片路径改为http：//的格式
            $data = array(
                'user_id'             => $user->id,
                'theme_name'          => $data['title'],
                'img'                 => $data['image'],
                'theme_introduction'  => $data['description'],
                'is_position'         => $data['is_position'],
                'is_head_figure'      => $data['is_head_figure'],
            );
            var_dump($data);
            //入库操作
            try {
                $id = model('Theme')->add($data);
            }catch (\Exception $e) {
                return $this->result('', config('code.FAILURE'), '新增失败');
            }

            if ($id) {
                return $this->result(['jump_url' =>url('theme/index')], config('code.SUCCESS'), 'OK');
            }else {
                return $this->result('', config('code.FAILURE'), '新增失败');
            }

        }else {
            return $this->fetch();
        }

    }
}