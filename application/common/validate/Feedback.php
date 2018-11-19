<?php
/**
 * Created by PhpStorm.
 * User: 龙思杰
 * Date: 2018/10/18
 * Time: 10:14
 */
namespace app\common\validate;

use think\Validate;

class Feedback extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'type_name'         => 'require|max:30',
        'content'           => 'max:300',
        'feedback_type_id'  => 'require|max:20',
    ];

    //应用场景
    protected $scene = [
        'submitFeedback'    => ['content', 'feedback_type_id'],
        'addType'           => ['type_name'],
    ];
}