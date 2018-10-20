<?php
/**
 * Created by PhpStorm.
 * User: 龙思杰
 * Date: 2018/10/18
 * Time: 10:09
 */
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use think\Exception;


/**
 * Class FeedbackController
 * 用户反馈控制器
 * @package app\api\controller\v1
 */
class FeedbackController extends AuthBaseController
{
    /**
     * 提交反馈
     * @return \json|\think\response\Json
     * @throws ApiException
     */
    public function submitFeedback()
    {
        if (!request()->isPost()) {
            return apiReturn(config('code.app_show_error'), '您没有权限', '', 403);
        }

        $param = input('param.');

        // validate
        $validate = validate('Feedback');
        if (!$validate->check($param, [], 'Feedback.submitFeedback')) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), '', 400);
        }

        $data = [
            'user_id'           => $this->user->id,
            'content'           => $param['content'],
            'feedback_type_id'  => $param['feedback_type_id'],
            //'status' => 0          // 数据库默认待审 为0，所以不用设置
        ];

        try {
            $id = model('Feedback')->add($data);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if ($id) {
            return apiReturn(config('code.app_show_success'), 'ok', '', 200);
        }else {
            return apiReturn(config('code.app_show_error'), '提交失败', '', 500);
        }

    }


    /**
     * 客户端获取反馈类型
     * @return \json|\think\response\Json
     * @throws ApiException
     */
    public function getFeedbackType()
    {
        if (!request()->isGet()) {
            return apiReturn(config('code.app_show_error'), '您没有权限', '', 403);
        }

        $whereData = [
            'status' => 1,  //已经启用的反馈类型
        ];

        try {
            $feedbackTypes = model('FeedbackType')->where($whereData)->select();
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        $result = [];
        foreach ($feedbackTypes as $key => $feedbackType) {
            $result[] = [
                "id"   => $feedbackType['id'],
                "name" => $feedbackType['type_name'],
            ];
        }

        return apiReturn(config('code.app_show_success'), 'OK', $result, 200);
    }
}