<?php
/**
 * Created by PhpStorm.
 * User: 龙思杰
 * Date: 2018/10/20
 * Time: 11:17
 */
namespace app\common\model;

class Feedback extends Base
{
    protected $table = 'feedback';

    /**
     * 查询反馈类型 后台自动分页
     * @param array $data
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getFeedback($data = [])
    {
        $data['fd.status'] = [
            'neq', config('code.status_delete')
        ];

        if (isset($data['create_time'])) {
            $data['fd.create_time'] = $data['create_time'];
            unset($data['create_time']);
        }

        if (isset($data['nickname'])) {
            $data['u.nickname'] = $data['nickname'];
            unset($data['nickname']);
        }

        $order = ['fd.id' => 'desc'];

        // 查询
        $result = $this->table($this->table)
            ->alias('fd')
            ->join('user u', 'u.id = fd.user_id')
            ->join('feedback_type fdt', 'fd.feedback_type_id = fdt.id')
            ->where($data)
            ->field('fdt.*,u.*,fd.*,fd.id as id')
            ->order($order)
            ->paginate();
        return $result;
    }
}
