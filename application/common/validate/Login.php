<?php
namespace app\common\validate;

use think\Validate;

class AdminUser extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'realname' => 'require|max:32',
        'cardno'   => 'require|max:10',
        'sno'      => 'require|max15',
        'sex'      => 'require',
        'college'  => 'require|max:30',
        'verify'   => 'require',
        'phone'    => 'require|number|length:11',
        'code'     => 'require|length:4'
    ];
    /*
    protected $message = [
        'name.require'    => '用户名必须',
        'cardno.require'  => '卡号必须',
        'sex.require'     => '性别必须',
        'college.require' => '学院必须',
        'sex.number'      => '性别类型必须为数字',
        'realname.max'    => '真实姓名最多32个字符',
        'cardno.max'      => '卡号最多10个字符',
        'college.max'     => '卡号最多30个字符',
    ];
    */
    //应用场景
    protected $scene = [
        'save'   =>  ['phone', 'code'],
    ];
}