<?php

namespace App\Models;

use App\Utils\Database;
use App\Utils\Model;

class User extends Model
{
    public string $name = '';

    public static function get(Database $db, int $id)
    {
        $fetched_array = $db->query("
            SELECT * FROM users
            WHERE
                id = :id
            ;
        ", ['id' => $id]);

        if (!$fetched_array)
            return null;
        $result = $fetched_array[0];

        $user = new User();
        $user->id = $result->id;
        $user->name = $result->name;
        return $user;
    }

    public static function create(Database $db, array $params)
    {
        $db->execute("
            INSERT INTO users (name)
            VALUES
                (:name)
            ;
        ", $params);

        $user = new User();
        $user->id = $db->lastInsertId();
        $user->name = $params['name'];
        return $user;
    }
}
