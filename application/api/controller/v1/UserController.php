<?php
namespace app\api\controller\v1;

use app\common\lib\Aes;
use app\common\model\User;
use think\Cache;

;

/**
 * 用户类，获取修改用户信息等功能
 * Class UserController
 * @package app\api\controller\v1
 */
class UserController extends AuthBaseController
{
    /**
     * 获取用户信息
     * user信息为其父类AuthBaseController获得
     * 用户基本信息较为隐私需要加密
     * @return \json|\think\response\Json
     */
    public function read()
    {
        $obj = new Aes();

        return apiReturn(config('code.app_show_success'), 'ok', $obj->encrypt($this->user));
    }

    /**
     * 更新用户信息
     * @return \json
     * @throws \think\exception\PDOException
     */
    public function update()
    {
        $putData = input('param.');

        // validate
        $validate = validate('User');
        if (!$validate->check($putData, [], 'User.update')) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
        }
        //严格判断要插入的数据
        $data = [];
        if (!empty($putData['avatar'])) {
            $data['avatar'] = $putData['avatar'];
        }
        if (!empty($putData['nickname'])) {
            $data['nickname'] = $putData['nickname'];
        }
        if (!empty($putData['signature'])) {
            $data['signature'] = $putData['signature'];
        }
        if (!empty($putData['home_img'])) {
            $data['home_img'] = $putData['home_img'];
        }

        if (empty($data)) {
            return apiReturn(config('code.app_show_error'), '数据不合法', [], 404);
        }

        $userModel = new User();
        $userModel->startTrans();
        try {
            // 判断是否已存在该昵称的用户
            $user = $userModel->lock(true)->where(['nickname' => $data['nickname']])->find();
            if (!$user || $user['id'] == $this->user->id) {
                $id = $userModel->save($data, ['id' => $this->user->id]);
                $userModel->commit();
                if ($id) {
                    $newInfoUser = $userModel::get(['id' => $id]);
                    Cache::set("user:{$id}", $newInfoUser);
                    return apiReturn(config('code.app_show_success'), 'ok', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '更新失败', [], 401);
                }
            } else {
                $userModel->commit();
                return apiReturn(config('code.app_show_error'), '用户名已存在', [], 403);
            }

        } catch (\Exception $e) {
            $userModel->rollback();
            return apiReturn(config('code.app_show_error'), $e->getMessage(), [], 500);
        }
    }

    /**
     * 获取用户关注其他用户的数量
     * @return \json
     */
    public function getUserAttentionUserCount()
    {
        if (request()->isGet()) {
            $id = input('get.id') ? input('get.id') : $this->user->id;
            try {
                $count = model('UserAttentionUser')->where(['attention_user_id' => $id])
                    ->count();
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }
            return apiReturn(config('code.app_show_success'), 'OK', ['count' => $count], 200);
        } else {
            return apiReturn(config('code.app_show_error'), 'error', [], 403);
        }
    }

    /**
     * 获取用户被其他用户关注的数量
     * @return \json
     */
    public function getUserBeAttentionCount()
    {
        if (request()->isGet()) {
            $id = input('get.id') ? input('get.id') : $this->user->id;
            try {
                $count = model('UserAttentionUser')->where(['be_attention_user_id' => $id])
                    ->count();
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }
            return apiReturn(config('code.app_show_success'), 'OK', ['count' => $count], 200);
        } else {
            return apiReturn(config('code.app_show_error'), 'error', [], 403);
        }
    }

    /**
     * 获取用户关注的用户
     * @return \json
     */
    public function getUserOfUserAttention()
    {
        if (request()->isGet()) {
            $id = input('get.id') ? input('get.id') : $this->user->id;
            try {
                $users = model('UserAttentionUser')->getUserOfUserAttention($id);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }

            // 整理数据
            $result = [];
            if ($users) {
                foreach ($users as $key => $user) {
                    $result[] = [
                        'user_id'           => $user['be_attention_user_id'],
                        'user_avatar'       => $user['avatar'],
                        'user_nickname'     => $user['nickname'],
                        'user_signature'    => $user['signature'],
                    ];
                }
            }

            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
        } else {
            return apiReturn(config('code.app_show_error'), 'error', [], 403);
        }
    }

    /**
     * 获取用户的粉丝列表（关注他的人）
     * @return \json
     */
    public function getUserOfUserBeAttention()
    {
        if (request()->isGet()) {
            $id = input('get.id') ? input('get.id') : $this->user->id;
            try {
                $users = model('UserAttentionUser')->getUserOfUserBeAttention($id);
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }

            // 整理数据
            $result = [];
            if ($users) {
                foreach ($users as $key => $user) {
                    $result[] = [
                        'user_id'           => $user['attention_user_id'],
                        'user_avatar'       => $user['avatar'],
                        'user_nickname'     => $user['nickname'],
                        'user_signature'    => $user['signature'],
                    ];
                }
            }

            return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
        } else {
            return apiReturn(config('code.app_show_error'), 'error', [], 403);
        }
    }

    /**
     * 检查昵称是否合法
     * 在用户选择保存对应数据前，若有填写昵称则访问此接口提前检查昵称合法性
     * @return \json|\think\response\Json
     */
    public function checkUserNicknamePass()
    {
        if (!request()->isGet()) {
            return apiReturn(config('code.app_show_error'), '您没有权限', '', 403);
        }

        $getData = input('get.');

        // validate
        $validate = validate('User');
        if (!$validate->check($getData, [], 'User.checkUserNicknamePass')) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
        }

        try {
            $count = model('User')->where(['nickname' => $getData['nickname']])->count();
        } catch (\Exception $e) {
            return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
        }

        if (!$count) {
            return apiReturn(config('code.app_show_success'), '昵称符合要求', [], 202);
        } else {
            return apiReturn(config('code.app_show_error'), '昵称已存在', [], 200);
        }
    }

    /**
     * 获取用户关注的主题数量
     * @return \json
     */
    public function getUserAttentionThemeCount()
    {
        if (request()->isGet()) {
            $id = input('get.id') ? input('get.id') : $this->user->id;
            try {
                $count = model('UserAttentionTheme')->where(['user_id' => $id])
                    ->count();
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), '', 500);
            }
            return apiReturn(config('code.app_show_success'), 'OK', ['count' => $count], 200);
        } else {
            return apiReturn(config('code.app_show_error'), 'error', [], 403);
        }
    }
}