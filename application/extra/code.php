<?php

/**
 * 和状态码相关的文案配置
 */
// TODO 将配置文件改为大写
return [
    'status_delete'         => -1,
    'status_normal'         => 1,
    'status_padding'        => 0,  //待审核
    'SUCCESS'               => 1,  //成功
    'FAILURE'               => 0,  //失败
    'source_admin'          => 0,  //来自admin用户
    'source_user'           => 1,  //来自普通用户
    'source_forward'        => 2,  //通过转发
    'app_show_success'      => 1,
    'app_show_error'        => 0,
    'article_type_original' => 0,  //原创文章
    'article_type_forward'  => 1,  //转发文章
    'user_normal'           => 1,  //用户正常
    'user_delete'           => -1,  //用户被删除
    'user_ban'              => 0,  //用户被禁止
    'is_position'           => 1, // 推荐状态
    'APP_CODE'              => 'Yf6u0XI8yVOx5OxSM7iyfXckGmtYNfuxI8CxmcE1ghHOcyGMrp5SCdouoQmV51qq', //静态资源文件的bbq专属code

    'STATUS_PENDING'        => 0, //未处理
    'STATUS_PROCESSED'      => 1, //已处理
];
