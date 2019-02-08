<?php
namespace app\common\model;

class Report extends Base
{
    protected $table = 'report';

    //后台管理-获取举报列表
    public function getReport($data=[]) {
        $results = model("Report")->where($data)->paginate(5);

        if (count($results)) {
            foreach($results as $result) {
                //得到举报者昵称
                $result['user_name'] = model('User')::get($result->user_id)->nickname;

                $report_type = array_flip(config('app.report_type'));
                if ($result['type']== $report_type['User']) {
                    $result['type'] = '用户';
                    $result['reported_content'] = model('User')::get($result->reported_id)->nickname;
                }
                else if ($result['type']== $report_type['Article']){
                    $result['type'] = '动态';
                    $result['reported_content'] = model('Article')::get($result->reported_id)->content;
                }
                else {
                    $result['type'] = '主题';
                    $result['reported_content'] = model('Theme')::get($result->reported_id)->theme_name; 
                }

            }

        }

        return $results;
    }

    //已弃用此api
    //api-获取举报列表。返回数组。
    public function getUserReport($user_id, $id=0) {
        $whereData = [];

        $whereData['user_id'] = ['=', $user_id];

        //如果限定了举报的id
        if ($id) {
            $whereData['id'] = ['=', $id];
        }

        $results = model('Report')->where($whereData)->select();

        $reports = [];
        if (count($results)) {
            $report_type = array_flip(config('app.report_type'));

            foreach ($results as  $result) {
                $report  = $result->data;

                if ($result['type']== $report_type['User']) {
                    $report['type'] = '用户';
                    $report['reported_content'] = model('User')::get($result->reported_id)->nickname;
                }
                else if ($result['type']== $report_type['Article']){
                    $report['type'] = '动态';
                    $report['reported_content'] = model('Article')::get($result->reported_id)->content;
                }
                else {
                    $report['type'] = '主题';
                    $report['reported_content'] = model('Theme')::get($result->reported_id)->theme_name; 
                }

                array_push($reports,$report);
            }
        }

        return $reports;
    }
}
