<?php
namespace app\admin\controller;

use think\Controller;
use Think\Exception;


class UserController extends BaseController
{
    public function index()
    {
        $this->model = 'User';
        $data = input('param.');

        $whereData = [];

        if (!empty($data['nickname'])) {
            $whereData['nickname'] = ['like', '%'.$data['nickname'].'%'];
        }
        // 获取数据
        $user = model('User')->getUser($whereData);
        //var_dump($theme);
        return $this->fetch('', [
            'user'      => $user,
        ]);
    }
}