<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2018/11/28
 * Time: 8:26 AM
 */
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;

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

            try {
                // 查询数据库中是否存在该关注
                $userAttentionTheme = model('UserAttentionTheme')->get($data);
                if ($userAttentionTheme) {
                    return apiReturn(config('code.app_show_error'), '已关注,请勿重复关注', [], 401);
                }
                // 未被关注
                $userAttentionThemeId = model('UserAttentionTheme')->add($data);
                if ($userAttentionThemeId) {
                    model('Theme')->where(['id' => $id])->setInc('attention');
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
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

            try {
                // 查询数据库中是否存在点赞
                $userAttentionTheme = model('UserAttentionTheme')->get($data);
                if (empty($userAttentionTheme)) {
                    return apiReturn(config('code.app_show_error'), '没有被关注过，无法取消', [], 401);
                }
                $userAttentionThemeId = model('UserAttentionTheme')->where($data)->delete();
                if ($userAttentionThemeId) {
                    model('Theme')->where(['id' => $id])->setDec('attention');
                    return apiReturn(config('code.app_show_success'), 'OK', [], 202);
                } else {
                    return apiReturn(config('code.app_show_error'), '内部错误，取消关注失败', [], 500);
                }
            } catch (\Exception $e) {
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
                // 查询数据库中是否存在点赞
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
}