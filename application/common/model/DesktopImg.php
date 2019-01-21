<?php
namespace app\common\model;

class DesktopImg extends Base
{
    protected $table = "desktop_img";
    public function getImg()
    {
        $data['status'] = [
            'neq', config('code.status_delete')
        ];
        $order = ['id' => 'description'];
        $result = $this->where($data)
            ->order($order)
            ->paginate();

        return $result;
    }
}