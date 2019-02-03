<?php
namespace app\api\controller\v1;

use app\api\controller\CommonController;
use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use app\common\model\User;
use think\Cache;

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
     * @throws \think\exception\DbException
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
     * @return bool
     * @throws \think\exception\DbException
     */
    public function isLogin()
    {
        if (empty($this->headers['access_user_token'])) {
            return false;
        }

        $obj = new Aes();
        $access_user_token = $obj->decrypt($this->headers['access_user_token']);

        $bool = IAuth::checkAccessUserTokenPass($access_user_token);
        if (!$bool) {
            return false;
        }

        list($token, $id) = explode("||", $access_user_token);
        // 启用redis缓存，若缓存中不存在则查询MySQL
        if (!$user = Cache::get("user:{$id}")) {
            $user = User::get(['token' => $token]);
            Cache::set("user:{$id}", $user);
        }

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