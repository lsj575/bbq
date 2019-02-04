<?php
namespace app\common\model;

class SlideImg extends Base
{
    protected $table = "slide_img";
    public function getImg($data)
    {
        $data['status'] = [
            'neq', config('code.status_delete')
        ];
        $order = array('status' => 'desc', 'order' => 'desc');
        $result = $this->where($data)
            ->order($order)
            ->paginate();

        return $result;
    }
}