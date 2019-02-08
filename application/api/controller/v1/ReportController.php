<?php
/**
 * Created by PhpStorm.
 * User: miracle
 * Date: 2019/1/19
 * Time: 10:23 PM
 */
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
/**
 * 举报控制器
 * Class ReportController
 * @package app\api\controller\v1
 */
class ReportController extends AuthBaseController
{
    /**
     * 提交举报
     * @return \json
     * @throws ApiException
     */
    public function save()
    {
        // strip_tags 剥去字符串中的 HTML、XML 以及 PHP 的标签
        $data = input('post.', [], 'strip_tags');

        //type content user_id reported_id
        //validate
        $validate = validate('Report');
        if (!$validate->check($data, [], 'save')) {
            return apiReturn(config('code.app_show_error'), $validate->getError(), [], 403);
        }
        // 查询被举报的内容（用户、动态、主题）是否正常
        // 判断此id的内容是否存在，且状态是否正常
        try {
            $model = $this->getReportType($data['type']);
            if ($model == null) {
                return apiReturn(config('code.app_show_error'), '类型错误', [], 403);
            }
            $content = model($model)->get(['id' => $data['reported_id'], 'status' => config('code.status_normal')]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }

        if (!$content) {
            return apiReturn(config('code.app_show_error'), '举报内容不存在', [], 403);
        }

        $data['user_id'] = $this->user->id;
        try {
            $reportId = model('Report')->add($data);
            if ($reportId) {
                return apiReturn(config('code.app_show_success'), 'OK', [], 202);
            } else {
                return apiReturn(config('code.app_show_error'), '举报失败', [], 500);
            }
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * 此api已弃用。先留着
     *获取当前用户提交的举报。可选参数：举报id
     *@return json
     */
    public function getReport($id=0) {
        
        $results = getUserReport($this->user->id, $id);

        if (!count($results)) {
        
        }

        if($id) {
            return apiReturn(config('code.app_show_success'));
        }
    }

    /**
     * 获取类型
     * @param $type
     * @return mixed
     */
    private function getReportType($type)
    {
        $type_arr = config('app.report_type');
        return isset($type_arr[$type]) ? $type_arr[$type] : null;
    }
}
