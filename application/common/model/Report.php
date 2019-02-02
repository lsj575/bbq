<?php
namespace app\common\model;

class Report extends Base
{
    protected $table = 'report';

    public function getReport($data=[]) {
        $results = model("Report")->where($data)->paginate(5);

        if (count($results)) {
            foreach($results as $result) {
                //得到举报者昵称
                $result['user_id'] = model('User')::get($result->user_id)->nickname;

                
                $report_type = array_flip(config('app.report_type'));
                if ($result['type']== $report_type['User']) {
                    $result['type'] = '用户';
                    $result['reported_id'] = model('User')::get($result->reported_id)->nickname;
                }
                else if ($result['type']== $report_type['Article']){
                    $result['type'] = '动态';
                    $result['reported_id'] = model('Article')::get($result->reported_id)->content;
                }
                else {
                    $result['type'] = '主题';
                    $result['reported_id'] = model('Theme')::get($result->reported_id)->theme_name; 
                }

            }

        }

        return $results;
    }
}
