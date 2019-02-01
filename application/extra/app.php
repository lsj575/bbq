<?php

return [
    'default_nickname'          => '小Q',
    'password_pre_halt'         => '_#token_bbq',  //密码加密盐
    'aes_key'                   => 'token_bbq_123789',      //aes加密密钥
    'aes_vi'                    => 'token1234BBQ4321',
    'app_types'                 => [
        'ios',
        'android',
    ],
    'sign_time'                 => 10,  // sign失效时间
    'sign_cache_time'           => 20,  // sign缓存失效时间
    'login_time_out_day'        => 180, // 登录token失效时间
    'access_user_token_time'    => 10,  // access_user_token失效时间
    'report_type'               => [    // 举报的类型
        '1' => 'User',
        '2' => 'Article',
        '3' => 'Theme',
    ],
];