<?php

namespace App\Utils;

use PDO;

class Database
{
    private $connection;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $port = $_ENV['DB_PORT'] ?? '3306';
        $db = $_ENV['DB_DATABASE'] ?? 'vktask';
        $user = $_ENV['DB_USERNAME'] ?? 'root';
        $pass = $_ENV['DB_PASSWORD'] ?? '';

        try {
            $this->connection = new PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function prepare(string $sql, array $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }
        return $stmt;
    }

    public function query(string $sql, array $params = [])
    {
        try {
            $stmt = $this->prepare($sql, $params);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function execute(string $sql, array $params = [])
    {
        try {
            $stmt = $this->prepare($sql, $params);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}
