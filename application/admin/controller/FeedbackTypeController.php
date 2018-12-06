<?php
/**
 * Created by PhpStorm.
 * User: 龙思杰
 * Date: 2018/10/21
 * Time: 16:53
 */
namespace app\admin\controller;

class FeedbackTypeController extends BaseController
{
    /**
     * 获取反馈类型列表
     * 可根据类型名来查询对应反馈类型
     * @return mixed
     */
    public function index()
    {
        $this->model = 'FeedbackType';
        $data = input('param.');

        $whereData = [];

        if (!empty($data['type_name'])) {
            $whereData['type_name'] = ['like', '%'.$data['type_name'].'%'];
        }
        // 获取数据
        $feedback_type = model('FeedbackType')->getFeedbackType($whereData);

        return $this->fetch('index', [
            'feedback_type'      => $feedback_type,
        ]);
    }

    /**
     * 添加反馈类型方法
     * @return mixed
     */
    public function addType()
    {
        if (request()->isPost()) {
            $data = input('post.');

            // 数据需要做校验
            $validate = validate('Feedback')->scene('addType');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            // 获取session
            $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));

            $data = array(
                'type_name'         => $data['type_name'],
                // 'status'            => 0,         status字段数据库默认值为0，表示未启用
            );

            // 入库操作
            try {
                // 先检查类型是否已经存在
                $bool = model('FeedbackType')->checkTypeNameIsExit($data);
                if ($bool) {
                    return json(['data' => '', 'code' => config('code.FAILURE'), 'msg' => '类型名已经存在']);
                }
                $id = model('FeedbackType')->add($data);
            }catch (\Exception $e) {
                return json(['data' => '', 'code' => config('code.FAILURE'), 'msg' => $e->getMessage()]);
            }

            if ($id) {
                return json(['data' => ['jump_url' => url('feedback/type_index')], 'code' => config('code.SUCCESS'), 'msg' => '新增成功']);
            }else {
                return json(['data' => '', 'code' => config('code.FAILURE'), 'msg' => '新增失败']);
            }

        }else {
            return $this->fetch('index');
        }
    }
}