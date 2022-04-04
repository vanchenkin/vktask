<?php

namespace App\Controllers;

use App\Utils\Response;
use App\Utils\Request;
use App\Utils\Database;
use App\Models\Review;

class PhoneController
{
    public static $COUNTRY_CODES = [
        '+7' => 'RU(Россия)',
        '+1' => 'US(США)',
        '+86' => 'CH(Китай)',
        '+52' => 'MX(Максика)',
        '+1905' => 'MX(Мексика)',
    ];

    public static function validatePhone(string $phone)
    {
        preg_match('/^\+?\d+$/', $phone, $matches);
        return $matches;
    }

    public static function getCountry(Request $request)
    {
        $phone = $request->phone;

        if (!$phone || !self::validatePhone($phone)) {
            return Response::json([
                'message' => 'Empty phone or wrong format'
            ], 400);
        }

        $country = "RU(Россия)";
        foreach (self::$COUNTRY_CODES as $code => $code_country) {
            if (substr($phone, 0, strlen($code)) === $code) {
                $country = $code_country;
            }
        }

        return Response::json([
            'country' => $country
        ]);
    }

    public static function search(Database $db, Request $request)
    {
        $phone = $request->phone;

        if (!$phone || !self::validatePhone($phone)) {
            return Response::json([
                'message' => 'Empty phone or wrong format'
            ], 400);
        }

        $reviews = Review::search($db, [
            'phone' => $phone,
        ]);

        return Response::json([
            'message' => 'Success',
            'content' => $reviews,
        ], 200);
    }
}
