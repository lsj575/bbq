<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2019/1/27
 * Time: 6:21 PM
 */
namespace app\common\validate;

use think\Validate;

class Report extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'type'          => 'require|number',
        'content'       => 'require|max:100',
        'reported_id'   => 'require|number'
    ];

    //应用场景
    protected $scene = [
        'save'   =>  ['type', 'content', 'user_id', 'reported_id'],
    ];
}