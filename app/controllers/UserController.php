<?php

namespace App\Controllers;

use App\Utils\Response;
use App\Utils\Request;
use App\Utils\Database;
use App\Models\Review;
use App\Models\User;

class UserController
{
    public static function create(Database $db, Request $request)
    {
        $name = $request->name;

        if (!$name)
            return Response::json([
                'message' => 'Name cannot be empty'
            ], 400);

        User::create($db, [
            'name' => $name,
        ]);

        return Response::json([
            'message' => 'Success'
        ], 201);
    }

    public static function rate(Database $db, Request $request)
    {
        $review_id = $request->review_id;
        $type = $request->type;
        $user_id = $request->user_id;

        if (!$review_id)
            return Response::json([
                'message' => 'Should provide review id'
            ], 404);

        if ($type !== 'PLUS' && $type !== 'MINUS')
            return Response::json([
                'message' => 'Type should be PLUS or MINUS'
            ], 404);

        if (!$user_id)
            return Response::json([
                'message' => 'Should be authorized(provide user id)'
            ], 404);

        $review = Review::get($db, $review_id);

        if (!$review)
            return Response::json([
                'message' => 'Review not found'
            ], 404);

        $user = User::get($db, $user_id);

        if (!$user)
            return Response::json([
                'message' => 'User not found'
            ], 404);

        $review->rate($db, $user, $type);

        return Response::json([
            'message' => 'Success'
        ], 201);
    }
}
