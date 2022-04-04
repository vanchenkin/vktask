<?php

namespace App\Models;

use App\Utils\Database;
use App\Utils\Model;
use App\Models\User;


class Review extends Model
{
    public string $phone = '';
    public string $text = '';
    public ?int $user_id = null;

    public static function create(Database $db, array $params)
    {
        $db->execute("
            INSERT INTO reviews (phone, text, user_id)
            VALUES
                (:phone, :text, :user_id)
            ;
        ", $params);

        $review = new Review();
        $review->id = $db->lastInsertId();
        $review->phone = $params['phone'];
        $review->text = $params['text'];
        $review->user_id = $params['user_id'];
        return $review;
    }

    public static function get(Database $db, int $id)
    {
        $fetched_array = $db->query("
            SELECT * FROM reviews
            WHERE
                id = :id
            ;
        ", ['id' => $id]);

        if (!$fetched_array)
            return null;
        $result = $fetched_array[0];

        $review = new Review();
        $review->id = $result->id;
        $review->phone = $result->phone;
        $review->text = $result->text;
        $review->user_id = $result->user_id;
        return $review;
    }

    /**
     * Returns reviews for input phone with rating and user name
     *
     * @param Database $db
     * @param string $phone
     * @return object
     */
    public static function getByPhone(Database $db, string $phone)
    {
        return $db->query("
            SELECT
                *,
                (
                    SELECT
                        IFNULL(
                            SUM(review_user.type = 'PLUS') -
                            SUM(review_user.type = 'MINUS')
                        ,0)
                    FROM review_user
                    WHERE reviews.id = review_user.review_id
                ) rating,
                (
                    SELECT
                        name
                    FROM users
                    WHERE reviews.user_id = users.id
                ) user_name
            FROM
                reviews
            WHERE
                phone = :phone
            GROUP BY
                reviews.id
            ;
        ", ['phone' => $phone]);
    }

    /**
     * Search reviews where phone starts with input string
     * Additionally returns count of reviews for this phones
     *
     * @param Database $db
     * @param string $phone
     * @return object
     */
    public static function search(Database $db, string $phone)
    {
        return $db->query("
            SELECT DISTINCT
                id,
                phone,
                COUNT(*) review_count
            FROM
                reviews
            WHERE
                phone LIKE CONCAT(:phone, '%')
            GROUP BY
                phone
            ;
        ", ['phone' => $phone]);
    }

    /**
     * Rate review
     *
     * @param Database $db
     * @param User $user
     * @param string $type
     * @return boolean
     */
    public function rate(Database $db, User $user, string $type)
    {
        return $db->execute("
            INSERT INTO review_user (review_id, user_id, type)
            VALUES
                (:review_id, :user_id, :type)
            ON DUPLICATE KEY UPDATE
                type = :type
            ;
        ", [
            'review_id' => $this->id,
            'user_id' => $user->id,
            'type' => $type,
        ]);
    }
}
