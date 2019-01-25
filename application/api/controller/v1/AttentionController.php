<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/28
 * Time: 8:26 AM
 */
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use think\Db;

/**
 * 点赞相关
 * Class UpvoteController
 * @package app\api\controller\v1
 */
class AttentionController extends AuthBaseController
{
    /**
     * 关注主题
     * @return \json
     * @throws ApiException
     */
    public function attentionTheme()
    {
        $id = input('post.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }
        // 判断此id的主题是否存在，且状态是否正常
        try {
            $theme = model('Theme')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($theme) {
            $data = [
                'user_id' => $this->user->id,
                'theme_id' => $id,
            ];

            // 开启事务，防止插入数据时异常导致的脏数据
            Db::startTrans();
            try {
                // 查询数据库中是否存在该关注
                $userAttentionTheme = Db::table('user_attention_theme')->find($data);
                if ($userAttentionTheme) {
                    return apiReturn(config('code.app_show_error'), '已关注,请勿重复关注', [], 401);
                }
                // 未被关注
                $userAttentionThemeId = Db::table('user_attention_theme')->insert($data);
                if ($userAttentionThemeId) {
                    Db::table('theme')->where(['id' => $id])->setInc('attention');
                    Db::commit();
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    Db::rollback();
                    return apiReturn(config('code.app_show_error'), '内部错误，关注失败', [], 500);
                }
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), [], 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该主题', [], 403);
        }
    }

    /**
     * 取消关注主题
     * @return \json
     * @throws ApiException
     */
    public function deleteAttentionTheme()
    {
        $id = input('delete.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }

        // 判断此id的主题是否存在，且状态是否正常
        try {
            $theme = model('Theme')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($theme) {
            $data = [
                'user_id' => $this->user->id,
                'theme_id' => $id,
            ];

            Db::startTrans();
            try {
                // 查询数据库中是否存在关注
                $userAttentionTheme = Db::table('user_attention_theme')->find($data);
                if (empty($userAttentionTheme)) {
                    return apiReturn(config('code.app_show_error'), '没有被关注过，无法取消', [], 401);
                }
                $userAttentionThemeId = Db::table('user_attention_theme')->where($data)->delete();
                if ($userAttentionThemeId) {
                    Db::table('theme')->where(['id' => $id])->setDec('attention');
                    Db::commit();
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，取消关注失败', [], 500);
                }
            } catch (\Exception $e) {
                Db::rollback();
                return apiReturn(config('code.app_show_error'), $e->getMessage(), [], 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该主题', [], 403);
        }
    }


    /**
     * 获取主题是否被某用户关注
     * @return \json
     * @throws ApiException
     */
    public function readAttentionTheme()
    {
        $id = input('param.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }
        // 判断此id的文章是否存在，且状态是否正常
        try {
            $theme = model('Theme')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($theme) {
            $data = [
                'user_id' => $this->user->id,
                'theme_id' => $id,
            ];

            try {
                // 查询数据库中是否存在关注
                $userAttentionTheme = model('UserAttentionTheme')->get($data);
                if ($userAttentionTheme) {
                    return apiReturn(config('code.app_show_success'), 'OK', ['isAttention' => 1], 200);
                } else {
                    return apiReturn(config('code.app_show_success'), 'OK', ['isAttention' => 0], 200);
                }
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), [], 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该主题', [], 403);
        }
    }

    /**
     * 用户关注用户
     * @return \json
     * @throws ApiException
     */
    public function attentionUser()
    {
        $id = input('post.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }
        // 判断此id的用户是否存在，且状态是否正常
        try {
            $User = model('User')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($User) {
            $data = [
                'attention_user_id'     => $this->user->id,
                'be_attention_user_id'  => $id,
            ];

            try {
                // 查询数据库中是否存在该关注
                $userAttentionUser = model('UserAttentionUser')->get($data);
                if ($userAttentionUser) {
                    return apiReturn(config('code.app_show_error'), '已关注,请勿重复关注', [], 401);
                }
                // 未被关注
                $userAttentionUserId = model('UserAttentionUser')->add($data);
                if ($userAttentionUserId) {
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，关注失败', [], 500);
                }
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), [], 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该用户', [], 403);
        }
    }

    /**
     * 取消关注用户
     * @return \json
     * @throws ApiException
     */
    public function deleteAttentionUser()
    {
        $id = input('delete.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }

        // 判断此id的用户是否存在，且状态是否正常
        try {
            $User = model('User')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($User) {
            $data = [
                'attention_user_id'     => $this->user->id,
                'be_attention_user_id'  => $id,
            ];

            try {
                // 查询数据库中是否存在关注
                $userAttentionUser = model('UserAttentionUser')->get($data);
                if (empty($userAttentionUser)) {
                    return apiReturn(config('code.app_show_error'), '没有被关注过，无法取消', [], 401);
                }
                $userAttentionUserId = model('UserAttentionUser')->where($data)->delete();
                if ($userAttentionUserId) {
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，取消关注失败', [], 500);
                }
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), [], 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该用户', [], 403);
        }
    }

    /**
     * 获取用户是否被某用户关注
     * @return \json
     * @throws ApiException
     */
    public function readAttentionUser()
    {
        $id = input('param.id', 0, 'intval');
        if (!$id) {
            return apiReturn(config('code.app_show_error'), 'id不存在', [], 404);
        }
        // 判断此id的用户是否存在，且状态是否正常
        try {
            $User = model('User')->get(['id' => $id, 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($User) {
            $data = [
                'attention_user_id'     => $this->user->id,
                'be_attention_user_id'  => $id,
            ];

            try {
                // 查询数据库中是否存在关注
                $userAttentionUser = model('UserAttentionUser')->get($data);
                if ($userAttentionUser) {
                    return apiReturn(config('code.app_show_success'), 'OK', ['isAttention' => 1], 200);
                } else {
                    return apiReturn(config('code.app_show_success'), 'OK', ['isAttention' => 0], 200);
                }
            } catch (\Exception $e) {
                return apiReturn(config('code.app_show_error'), $e->getMessage(), [], 500);
            }
        } else {
            return apiReturn(config('code.app_show_error'), '不存在该用户', [], 403);
        }
    }
}