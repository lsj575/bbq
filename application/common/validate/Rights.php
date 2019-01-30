<?php
namespace app\common\validate;

use think\Validate;

class Rights extends Validate{
    protected $rule = [
        'controller' => 'require|max:15',
        'action'     => 'require|max:15',
        'powername'  => 'require|max:15',
    ];
}
