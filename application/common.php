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
    return $str ? '<span style="color:red"> 是</span>' : '<span > 否</span>';
}
function getStatusName($status)
{
    return $status ? '<span> 已发布</span>' : '<span > 待审核</span>';
}