<?php
namespace app\api\controller\v1;

use app\api\controller\CommonController;
use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\model\User;

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
    /**
     * 登录用户的基本信息
     * @var null
     */
    public $user = null;

    /**
     * 初始化
     * @throws ApiException
     */
    public function _initialize()
    {
        parent::_initialize();
        if (!$this->isLogin()) {
            throw new ApiException('您没有登录', 401);
        }
    }

    /**
     * 判断是否登录
     * TODO 客户端工程师对token进行解密再进行加密后上传【客户端加密算法待商榷,可仿照sign】
     * @return bool
     */
    public function isLogin()
    {
        if (empty($this->headers['access_user_token'])) {
            return false;
        }

        $obj = new Aes();
        $access_user_token = $obj->decrypt($this->headers['access_user_token']);
        if (empty($access_user_token)) {
            return false;
        }

        //如果没有两个|| ，则也不成立
        if (!preg_match('/||/', $access_user_token)) {
            return false;
        }
        list($token, $id) = explode("||", $access_user_token);
        $user = User::get(['token' => $token]);

        if (!$user || config('code.user_normal') != $user->status) {
            return false;
        }

        //判断时间是否过期
        if (time() > $user->time_out) {
            return false;
        }

        $this->user = $user;
        return true;
    }
}