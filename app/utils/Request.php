<?php

namespace App\Utils;

class Request
{
    private $request_params;
    private $request_body;
    private $request_method;
    private $request_uri;

    public function __construct()
    {
        $this->request_uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->request_method = $_SERVER["REQUEST_METHOD"];
        $this->request_body = json_decode(file_get_contents('php://input'), true);
        parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $request_params);
    }

    public function getUri()
    {
        return $this->request_uri;
    }

    public function getBody()
    {
        return $this->request_body;
    }

    public function getMethod()
    {
        return $this->request_method;
    }
}
