<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'nickname'  => 'require|chsDash|max:30',
        'signature' => 'max:200',
        'avatar'    => 'max:255',
        'home_img'  => 'max:255',
    ];

    //应用场景
    protected $scene = [
        'update'   =>  ['nickname', 'signature', 'avatar', 'home_img'],
        'checkUserNicknamePass' => ['nickname',]
    ];
}