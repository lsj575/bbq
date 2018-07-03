<?php
namespace app\common\validate;

use think\Validate;

class AdminUser extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'username' => 'require|max:20',
        'password' => 'require|max:20',
    ];
}