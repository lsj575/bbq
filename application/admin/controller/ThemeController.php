<?php
namespace app\admin\controller;

use think\Controller;

class ThemeController extends BaseController
{
    public function add()
    {
        return $this->fetch();
    }
}