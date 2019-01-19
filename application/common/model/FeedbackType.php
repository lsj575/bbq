<?php
/**
 * Created by PhpStorm.
 * User: 龙思杰
 * Date: 2018/10/18
 * Time: 10:19
 */

namespace app\common\model;

class FeedbackType extends Base
{
    protected $table = 'feedback_type';

    /**
     * 查询反馈类型 后台自动分页
     * @param array $data
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getFeedbackType($data = [])
    {
        $data['status'] = [
            'neq', config('code.status_delete')
        ];

        $order = ['id' => 'desc'];

        // 查询
        $result = $this->where($data)
            ->order($order)
            ->paginate();

        return $result;
    }

    /**
     * 查询typename是否已经存在
     * @param array $data
     * @return int|string
     */
    public function checkTypeNameIsExit($data = [])
    {
        $data['status'] = [
            'neq', config('code.status_delete')
        ];

        $count = $this->where($data)
            ->count();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}