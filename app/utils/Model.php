<?php

namespace APp\Utils;

abstract class Model
{
    private int $id;

    public function __get($param)
    {
        if ($param == 'id')
            return $this->id;
        return null;
    }
}
