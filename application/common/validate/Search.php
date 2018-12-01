<?php
namespace app\common\validate;

use think\Validate;

class Theme extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'title'       => 'require|max:30',
        'description' => 'require',
        'image'       => 'require',
    ];
}