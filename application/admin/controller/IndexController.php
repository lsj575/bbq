<?php
namespace app\admin\controller;

use think\Controller;

class IndexController extends  BaseController
{
    public function index()
    {
        return $this->fetch();
    }

    public function welcome()
    {
        $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));
        //获取管理员信息
        $user_data = [
            'username'          =>  $user->username,
            'last_login_ip'     =>  $user->last_login_ip,
            'last_login_time'   =>  date("Y-m-d h:i:sa",$user->last_login_time),
        ];
        $bbq_info_total = [
            'user'      =>  model('User')->count(),
            'theme'     =>  model('Theme')->count(),
            'article'   =>  model('Article')->count(),
            'admin'     =>  model('AdminUser')->count(),
            'feedback'  =>  model('Feedback')->count(),
            'report'    =>  model('Report')->count()
        ];
        //获取当天信息
        $today=strtotime(date('Y-m-d 00:00:00'));
        $data['create_time'] = array('egt',$today);
        $bbq_info_today = [
            'user'      =>  model('User')->where($data)->count(),
            'theme'     =>  model('Theme')->where($data)->count(),
            'article'   =>  model('Article')->where($data)->count(),
            'admin'     =>  model('AdminUser')->where($data)->count(),
            'feedback'  =>  model('Feedback')->where($data)->count(),
            'report'    =>  model('Report')->where($data)->count()
        ];
        //获取昨天信息
        $yesterday=strtotime(date('Y-m-d 00:00:00',strtotime('-1 days')));
        $data['create_time'] = array('between',array($yesterday,$today));
        $bbq_info_yesterday = [
            'user'      =>  model('User')->where($data)->count(),
            'theme'     =>  model('Theme')->where($data)->count(),
            'article'   =>  model('Article')->where($data)->count(),
            'admin'     =>  model('AdminUser')->where($data)->count(),
            'feedback'  =>  model('Feedback')->where($data)->count(),
            'report'    =>  model('Report')->where($data)->count()
        ];
        //获取本周信息
        $start = strtotime(date('Y-m-d',(time()-((date('w')==0?7:date('w'))-1)*24*3600)));
        $end = strtotime(date('Y-m-d H:i:s'));
        $data['create_time'] = array('between',array($start,$end));
        $bbq_info_week = [
            'user'      =>  model('User')->where($data)->count(),
            'theme'     =>  model('Theme')->where($data)->count(),
            'article'   =>  model('Article')->where($data)->count(),
            'admin'     =>  model('AdminUser')->where($data)->count(),
            'feedback'  =>  model('Feedback')->where($data)->count(),
            'report'    =>  model('Report')->where($data)->count()
        ];
        //获取本月信息
        $start=strtotime(date('Y-m-01 00:00:00'));
        $end = strtotime(date('Y-m-d H:i:s'));
        $data['create_time'] = array('between',array($start,$end));
        $bbq_info_month = [
            'user'      =>  model('User')->where($data)->count(),
            'theme'     =>  model('Theme')->where($data)->count(),
            'article'   =>  model('Article')->where($data)->count(),
            'admin'     =>  model('AdminUser')->where($data)->count(),
            'feedback'  =>  model('Feedback')->where($data)->count(),
            'report'    =>  model('Report')->where($data)->count()
        ];
        return $this->fetch('',[
            'user'      =>  $user_data,
            'total'     =>  $bbq_info_total,
            'today'     =>  $bbq_info_today,
            'yesterday' =>  $bbq_info_yesterday,
            'week'      =>  $bbq_info_week,
            'month'     =>  $bbq_info_month
        ]);
    }
}
