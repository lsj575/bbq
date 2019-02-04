<?php
namespace app\admin\controller;

/**
 * 主题控制器
 * Class ThemeController
 * @package app\admin\controller
 */
class ThemeController extends BaseController
{
    /**
     * 获取主题列表
     * 可根据时间和主题名来查询对应主题
     * @return mixed
     */
    public function index()
    {
        $this->model = 'Theme';
        $data = input('param.');

        $whereData = [];
        //转换查询条件
        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $whereData['create_time'] = [
                ['egt', strtotime($data['start_time'])],
                ['elt', strtotime($data['end_time'])],
            ];
        }
        if (!empty($data['title'])) {
            $whereData['theme_name'] = ['like', '%'.$data['title'].'%'];
        }
        // 获取数据
        $theme = model('Theme')->getTheme($whereData);
        //var_dump($theme);
        return $this->fetch('', [
            'theme'      => $theme,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time'   => empty($data['end_time']) ? '' : $data['end_time'],
        ]);
    }

    /**
     * 添加主题
     * @return mixed|void
     */
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
            (!isset($data['is_position'])) ? $data['is_position'] = 0 : $data['is_position'] = 1;
            //TODO 将图片路径改为http：//的格式
            $data = array(
                'user_id'             => $user->id,
                'theme_name'          => $data['title'],
                'img'                 => $data['image'],
                'theme_introduction'  => $data['description'],
                'is_position'         => $data['is_position'],
            );

            //入库操作
            try {
                $id = model('Theme')->add($data);
            }catch (\Exception $e) {
                return $this->result('', config('code.FAILURE'), '新增失败');
            }

            if ($id) {
                return $this->result(['jump_url' => url('theme/index')], config('code.SUCCESS'), 'OK');
            }else {
                return $this->result('', config('code.FAILURE'), '新增失败');
            }

        }else {
            return $this->fetch();
        }
    }

    /**
     * 主题编辑
     * @param int $id
     * @return mixed|void
     */
    public function edit($id = 0)
    {
        $this->model = 'Theme';
        if (request()->isPost()) {
            $data = input('post.');

            // 数据需要做校验
            $validate = validate('Theme');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            // 若表单未对推荐进行勾选，is_position需要主动赋值
            (!isset($data['is_position'])) ? $data['is_position'] = 0 : $data['is_position'] = 1;
            $data = array(
                'theme_name'          => $data['title'],
                'img'                 => $data['image'],
                'theme_introduction'  => $data['description'],
                'is_position'         => $data['is_position'],
            );
            //入库操作
            try {
                $id = model('Theme')->save($data, ['id' => $id]);
            }catch (\Exception $e) {
                return $this->result('', config('code.FAILURE'), '编辑失败');
            }

            if ($id) {
                return $this->result(['jump_url' => url('theme/index')], config('code.SUCCESS'), 'OK');
            }else {
                return $this->result('', config('code.FAILURE'), '编辑失败');
            }
        } else {
            if (!intval($id)) {
                return $this->error('ID不合法');
            }

            try {
                //通过id查询记录是否存在
                $res = model('Theme')->get($id);
                if (!$res) {
                    return $this->error('没有此条记录');
                }else {
                    return $this->fetch('', [
                        'theme' => $res,
                    ]);
                }
            }catch(\Exception $e){
                return $this->error($e->getMessage());
            }
        }

    }

}