<?php

namespace App\Utils;

use PDO;

class Database
{
    private $connection;

    public function __construct()
    {
        //TODO pass db parameters through constructor
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $db = $_ENV['DB_DATABASE'];
        $user = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];

        try {
            $this->connection = new PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }
}
