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
        // 转换查询条件
        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $whereData['create_time'] = [
                ['egt', strtotime($data['start_time'])],
                ['elt', strtotime($data['end_time'])],
            ];
        } else {
            unset($whereData['create_time']);
        }
        
        if (!empty($data['nickname'])) {
            $whereData['nickname'] = ['like', '%'.$data['nickname'].'%'];
        } else {
            unset($whereData['nickname']);
        }
        // 获取数据
        $feedback = model('Feedback')->getFeedback($whereData);

        return $this->fetch('', [
            'feedback'      => $feedback,
            'start_time'    => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time'      => empty($data['end_time']) ? '' : $data['end_time'],
        ]);
    }

}
