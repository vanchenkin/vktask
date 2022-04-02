<?php

namespace App\Utils;

class Response
{

    public static function json($array)
    {
        echo json_encode($array);
    }
}
