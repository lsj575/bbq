<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2019/2/12
 * Time: 4:31 PM
 */
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;

/**
 * 用户消息控制器
 * Class AdviceController
 * @package app\api\controller\v1
 */
class AdviceController extends AuthBaseController
{
    /**
     * 获取某用户的通知
     * @return \json
     * @throws ApiException
     */
    public function read()
    {
        try {
            $comment_advices = model('ArticleComment')->getAdviceComment($this->user->id);
            $user_advices = model('UserAdvice')
                ->where(['user_id' => $this->user->id, 'status' => config('code.status_normal')])
                ->order('create_time desc')
                ->select();
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($comment_advices || $user_advices) {
            // 整理返回数据
            $result = [];
            $result['user_advices'] = $user_advices;
            $result['comment_advices'] = $comment_advices;
            return apiReturn(config('code.app_show_success'), 'OK', $result, 202);
        } else {
            return apiReturn(config('code.app_show_success'), '暂无通知', [], 202);
        }
    }
}