<?php

namespace App\Models;

use App\Utils\Database;
use Dotenv\Util\Regex;

class Review
{
    private int $id;
    public string $phone = '';
    public string $text = '';
    public ?int $user_id = null;

    public function save()
    {
    }

    public static function create(Database $db, array $params)
    {
        $db->execute("
            INSERT INTO reviews (phone, text, user_id)
            VALUES (:phone, :text, :user_id);
        ", $params);

        $review = new Review();
        $review->id = $db->lastInsertId();
        $review->phone = $params['phone'];
        $review->text = $params['phone'];
        $review->user_id = $params['phone'];

        return $review;
    }
}
