<?php

use App\Http\Flash as Flash;

function flash($message = null, $type = null)
{
    $flash = app('App\Http\Flash');
    if (func_num_args() ==0) {
        return $flash;
    }
    return $flash->message($type, $message);
}
