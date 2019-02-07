<?php
/**
 * Created by PhpStorm.
 * User: 龙思杰
 * Date: 2018/10/18
 * Time: 10:14
 */
namespace app\common\validate;

use think\Validate;

class Article extends Validate
{
    //提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'id'                => 'require|number',
        'user_id'           => 'require|number',
        'theme_id'          => 'require|number',
        'content'           => 'max:500',
        'allow_comment'     => 'require|number',
        'allow_watermark'   => 'require|number',
    ];

    //应用场景
    protected $scene = [
        'getArticlesOfTheme'    => ['theme_id'],
        'save'                  => ['user_id', 'theme_id', 'content', 'allow_comment', 'allow_watermark'],
        'update'                => ['id', 'content', 'img', 'allow_comment', 'allow_watermark'],
    ];
}