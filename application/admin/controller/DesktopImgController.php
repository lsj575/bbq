<?php
/*
 * 首页图片管理
 */
namespace app\admin\controller;
use think\controller;

class DesktopImgController extends BaseController
{
    public function index()
    {
        $this->model = 'DesktopImg';
        $data = input('.param');

        $whereData = [];
        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $whereData['create_time'] = [
                ['egt', strtotime($data['start_time'])],
                ['elt', strtotime($data['end_time'])],
            ];
            //halt($data['start_time']);
        }
        if (!empty($data['description'])) {
            $whereData['description'] = ['like', '%'.$data['description'].'%'];
        }
        // 获取数据
        $desktop_img = model('DesktopImg')->getImg($whereData);
        //var_dump($theme);
        return $this->fetch('', [
            'desktop_img'      => $desktop_img,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time'   => empty($data['end_time']) ? '' : $data['end_time'],
        ]);
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            //校验数据
            $validate = validate('DesktopImage');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            //获取session
            $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));

            $data = array(
                'user_id'        => $user->id,
                'description'    => $data['description'],
                'img'            => $data['img'],
                'img_type'       => $data['img_type'],
            );
            //入库
            try {
                $id = model('desktop_img')->add($data);
            } catch (\Exception $e) {
                return $this->result('',config('code.FAILURE'),'新增失败');
            }

            if ($id) {
                return $this->result(['jump_url' => url('desktop_img/index')], config('code.SUCCESS'), 'OK');
            } else {
                return  $this->result('',config('code.FAILURE'),'新增失败');
            }

        } else {
            return $this->fetch();
        }
    }
}