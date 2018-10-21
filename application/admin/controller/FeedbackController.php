<?php
/**
 * Created by PhpStorm.
 * User: 龙思杰
 * Date: 2018/10/21
 * Time: 16:53
 */
namespace app\admin\controller;

class FeedbackController extends BaseController
{
    /**
     * 获取反馈列表
     * 可根据时间和用户名来查询对应反馈
     * @return mixed
     */
    public function index()
    {
        $this->model = 'Feedback';
        $data = input('param.');

        $whereData = [];
        //转换查询条件
        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $whereData['create_time'] = [
                ['egt', strtotime($data['start_time'])],
                ['elt', strtotime($data['end_time'])],
            ];
        } else {
            $whereData['create_time'] = [];
        }

        if (!empty($data['nickname'])) {
            $whereData['nickname'] = $data['nickname'];
        } else {
            $whereData['nickname'] = [];
        }
        // 获取数据
        $feedback = model('Feedback')->getFeedback($whereData);
        //var_dump($theme);
        return $this->fetch('', [
            'feedback'      => $feedback,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time'   => empty($data['end_time']) ? '' : $data['end_time'],
        ]);
    }


    /**
     * 获取反馈类型列表
     * 可根据类型名来查询对应反馈类型
     * @return mixed
     */
    public function typeIndex()
    {
        $this->model = 'FeedbackType';
        $data = input('param.');

        $whereData = [];

        if (!empty($data['title'])) {
            $whereData['feedback_type_name'] = ['like', '%'.$data['type_name'].'%'];
        }
        // 获取数据
        $feedback_type = model('FeedbackType')->getFeedbackType($whereData);
        //var_dump($theme);
        return $this->fetch('type_index', [
            'feedback_type'      => $feedback_type,
        ]);
    }
}