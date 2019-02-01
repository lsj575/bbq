<?php
namespace app\admin\controller;

use app\common\model\Report;

//举报管理
class ReportController extends BaseController{
    
    //获取评论列表
    public function index() {
        if(request()->isGet()) {
            $data = input('get.');

            $whereData=[];

            //按举报理由搜索
            if(!empty($data['content'])) {
                $whereData['content'] = ['like','%'.$data['content'].'%'];
            }

            //按被举报类型搜索
            if(!empty($data['type'])) {
                $whereData['type'] = ['=',$data['type']];
            }

            //按举报状态搜索
            if(isset($data['status'])) {
                $whereData['status'] = ['=',$data['status']];
            }

            //按被举报时间搜索
            if(!empty($data['start_time']) || !empty($data['end_time'])) {
                $whereData['create_time'] = [
                    ['egt',empty($data['start_time']) ? 946699200 : strtotime($data['start_time'])],
                    ['elt',empty($data['end_time'])  ? strtotime('now') : strtotime($data['end_time'])],
                ];
            }

            $report = model('Report')->getReport($whereData);
            return $this->fetch('',[
                'report'            => $report,
                'start_time'        => empty($data['start_time']) ? '' : $data['start_time'],
                'end_time'          => empty($data['end_time'])   ? '' : $data['end_time'],

                'STATUS_PENDING'    => config('code.STATUS_PENDING'),
                'STATUS_PROCESSED'  => config('code.STATUS_PROCESSED'),

                'report_type'       => array_flip(config('app.report_type')),
            ]);
        
        }
    }
}
