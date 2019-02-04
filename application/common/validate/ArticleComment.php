<?php
namespace app\common\validate;

use think\Validate;

class ArticleComment extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'article_id'    => 'require|number',
        'content'       => 'max:300',
        'parent_id'     => 'require|number',
        'img'           => 'string',
    ];

    protected $scene = [
        'save' => ['article_id', 'content', 'parent_id'],
    ];
}