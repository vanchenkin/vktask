<?php

namespace App\Controllers;

use App\Utils\Response;
use App\Utils\Request;
use App\Utils\Database;
use App\Models\Review;

class ReviewController
{
    public static function create(Database $db, Request $request)
    {
        //TODO check unique review
        $phone = $request->phone;
        $text = $request->text;
        $user_id = $request->user_id;

        if (!$phone || !$text || !PhoneController::validatePhone($phone))
            return Response::json([
                'message' => 'Empty phone or wrong format'
            ], 400);

        Review::create($db, [
            'phone' => $phone,
            'text' => $text,
            'user_id' => $user_id
        ]);

        return Response::json([
            'message' => 'Success'
        ], 201);
    }

    public static function get(Database $db, Request $request)
    {
        $phone = $request->phone;

        if (!$phone || !PhoneController::validatePhone($phone))
            return Response::json([
                'message' => 'Empty phone or wrong format'
            ], 400);

        $reviews = Review::filter($db, ['phone' => $phone]);

        return Response::json([
            'message' => 'Success',
            'content' => $reviews,
        ], 200);
    }
}
