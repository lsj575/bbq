<?php
namespace app\common\validate;

use think\Validate;

class Comment extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'article_id'    => 'require|number',
        'content'       => 'require|max:300',
        'to_user_id'    => 'require|number',
        'parent_id'     => 'require|number',
    ];

    protected $scene = [
        'save' => ['article_id', 'content', 'to_user_id', 'parent_id'],
    ];
}