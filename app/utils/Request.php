<?php

namespace App\Utils;

class Request
{
    private $storage;

    public function __construct()
    {
        $this->storage = $this->cleanInput($_REQUEST);
    }

    public function __get($name)
    {
        if (isset($this->storage[$name])) {
            return $this->storage[$name];
        }
    }

    private function cleanInput($data)
    {
        if (is_array($data)) {
            $cleaned = [];
            foreach ($data as $key => $value) {
                $cleaned[$key] = $this->cleanInput($value);
            }
            return $cleaned;
        }
        return trim(htmlspecialchars(urlencode($data), ENT_QUOTES));
    }
}
