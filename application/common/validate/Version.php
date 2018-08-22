<?php
namespace app\common\validate;

use think\Validate;

class Version extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'app_type'      => 'require|max:20',
        'version'       => 'require|max:8',
        'version_code'  => 'require|max:20',
        'apk_url'       => 'require|max:255',
        'upgrade_point' => 'require|max:500',
    ];

    //应用场景
    protected $scene = [
        'add'    =>  ['app_type', 'version', 'version_code', 'is_force', 'apk_url', 'upgrade_point'],
        'edit'   =>  ['app_type', 'version', 'version_code', 'is_force', 'apk_url', 'upgrade_point'],
    ];
}