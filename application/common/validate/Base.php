<?php
namespace app\common\validate;

use think\Validate;

class Base extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'id'     => 'require',
        'status' => 'require',
    ];
}