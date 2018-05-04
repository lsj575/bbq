<?php
function apireturn($errcode, $errmsg, $data, $status)
{
    return json([
        'errcode' => $errcode,
        'errmsg' => $errmsg,
        'data' => $data
    ], $status);
}