<?php

namespace App\Utils;

class DatabaseSeeder
{
    public static function createTables(Database $db)
    {
        $db->execute("
            CREATE TABLE IF NOT EXISTS reviews (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                phone VARCHAR(30) NOT NULL,
                text VARCHAR(1000) NOT NULL,
                user_id INT
            );
        ");

        $db->execute("
            CREATE TABLE IF NOT EXISTS users (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL
            );
        ");

        $db->execute("
            CREATE TABLE IF NOT EXISTS review_user (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                review_id INT NOT NULL,
                user_id INT NOT NULL,
                type enum('PLUS','MINUS') NOT NULL,
                UNIQUE KEY (review_id, user_id)
            );
        ");
    }
}
