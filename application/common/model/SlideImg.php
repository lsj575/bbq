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
        $order = ['id' => 'description'];
        $result = $this->where($data)
            ->order($order)
            ->paginate();

        return $result;
    }
}