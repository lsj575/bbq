<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function pagination($obj)
{
    if (!$obj) {
        return '';
    }

    $params = request()->param();
    return '<div class="bbq-app">'.$obj->appends($params)->render().'</div>';
}

function isPosition($str)
{
    return $str ? '<span style="color:red"> 是</span>' : '<span> 否</span>';
}

function getStatusName($status)
{
    return $status ? '<span> 已发布</span>' : '<span > 待审核</span>';
}

function theme_status($id, $status)
{
    $controller = request()->controller();
    $sta = $status == 1 ? 0 : 1;
    $url = url($controller.'/status', ['id' => $id, 'status' => $sta]);

    if ($status == 1) {
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='app_status(this)'><span class='label label-success radius'>已发布</span></a>";
    }elseif ($status == 0) {
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='app_status(this)'><span class='label label-danger radius'>待审核</span></a>";
    }

    return $str;
}

function user_status($id, $status)
{
    $controller = request()->controller();
    $sta = $status == 1 ? 0 : 1;
    $url = url($controller.'/status', ['id' => $id, 'status' => $sta]);

    if ($status == 1) {
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='app_status(this)'><span class='label label-success radius'>正常</span></a>";
    }elseif ($status == 0) {
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='app_status(this)'><span class='label label-danger radius'>被禁止</span></a>";
    }

    return $str;
}

/**
 * 通用化API接口数据输出
 * @param int $status
 * @param string $message
 * @param [] $data
 * @param int $httpCode
 * @return json
 */
function apiReturn($status, $message, $data=[], $httpCode=200)
{
    $result = [
        'status'  => $status,
        'message' => $message,
        'data'    => $data,
    ];

    return json($result, $httpCode);
}