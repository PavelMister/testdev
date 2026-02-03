<?php

namespace Core;

use Helpers\LoggingHelper;
use PDO;
use PDOException;

class Database
{
    private static ?self $instance = null;
    protected PDO $connection;

    /**
     * Constructor for database connection.
     * @throws \Exception
     */
    private function __construct() {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $db   = $_ENV['DB_NAME'] ?? '';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            LoggingHelper::saveError($e->getMessage());
            throw new \Exception('Database not connected');
        }
    }

    /**
     * Get current connection instance
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get current connection to database
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}