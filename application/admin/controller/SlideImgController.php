<?php
/*
 * 首页图片管理
 */
namespace app\admin\controller;
use think\controller;

class SlideImgController extends BaseController
{
    /**
     * 获取图片列表
     * 可根据时间和图片描述来查询对应图片
     * @return mixed
     */
    public function index()
    {
        $this->model = 'slide_img';
        $data = input('param.');

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
        $slide_img = model('SlideImg')->getImg($whereData);
        //var_dump($slide_img);
        return $this->fetch('', [
            'slide_img'      => $slide_img,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time'   => empty($data['end_time']) ? '' : $data['end_time'],
        ]);
    }
    /**
     * 添加图片
     * @return mixed
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            //校验数据
            $validate = validate('SlideImg');
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
                $id = model('slide_img')->add($data);
            } catch (\Exception $e) {
                return $this->result('',config('code.FAILURE'),'新增失败');
            }

            if ($id) {
                return $this->result(['jump_url' => url('slide_img/index')], config('code.SUCCESS'), 'OK');
            } else {
                return  $this->result('',config('code.FAILURE'),'新增失败');
            }

        } else {
            return $this->fetch();
        }
    }
    public function edit($id = 0)
    {
        if (request()->isPost()) {
            $data = input('post.');
            $id = $data['id'];
            //校验数据
            $validate = validate('SlideImg');
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
                $id = model('slide_img')->save($data, ["id" => $id]);
            } catch (\Exception $e) {
                return $this->result('',config('code.FAILURE'),'编辑失败');
            }
            if ($id) {
                return $this->result(['jump_url' => url('slide_img/index')], config('code.SUCCESS'), 'OK');
            } else {
                return  $this->result('',config('code.FAILURE'),'编辑失败');
            }

        } else {
            if (!intval($id)) {
                return $this->error('ID不合法');
            }
            try {
                //通过id查询记录是否存在
                $res = model('slide_img')->get($id);
                if (!$res) {
                    return $this->error('没有此条记录');
                }else {
                    return $this->fetch('', [
                        'slide_img' => $res,
                    ]);
                }
            }catch(\Exception $e){
                return $this->error($e->getMessage());
            }
        }

    }
}