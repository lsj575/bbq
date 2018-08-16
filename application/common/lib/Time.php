<?php
namespace app\common\lib;


class Time
{
    /**
     * 获取13位时间戳
     * @return int
     */
    public static function get13TimeStamp()
    {
        list($t1, $t2) = explode(' ', microtime());

        return $t2 . ceil($t1 * 1000);
    }

}