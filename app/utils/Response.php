<?php

namespace App\Utils;

class Response
{
    public static function json(array $array, int $code = 200)
    {
        http_response_code($code);
        $array['error'] = ($code >= 300 || $code < 200);
        $array['code'] = $code;
        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }
}
