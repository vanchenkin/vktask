<?php

namespace App\Controllers;

use App\Utils\Controller;
use App\Utils\Response;

class PhoneController extends Controller
{
    public static function getCountry($request)
    {

        Response::json($request->getBody());
    }
}
