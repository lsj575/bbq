<?php
namespace app\api\controller\v1;

use app\api\controller\CommonController;

/**
 * 客户端Auth登录基础类库
 * 每个接口（需要登录的，个人中心，点赞，评论）都需要继承
 * 判断access_user_token是合法
 * 用户信息-》user
 * Class AuthBaseController
 * @package app\api\controller\v1
 */
class AuthBaseController extends CommonController
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function isLogin()
    {
        if (empty($this->headers['access_user_token'])) {
            return false;
        }
    }
}