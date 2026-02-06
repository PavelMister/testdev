<?php

namespace Core;

use PDO;
use PDOException;
use Helpers\LoggingHelper;

class Database
{
    private static ?self $instance = null;
    protected PDO $connection;

    /**
     * Constructor for database connection.
     * @throws \Exception
     */
    private function __construct()
    {
        $config = Config::get('db');

        try {
            $this->connection = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
                $config['user'],
                $config['pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
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
