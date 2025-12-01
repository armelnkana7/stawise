<?php

namespace App\Core;

use PDO;

class Database
{
    protected static $pdo;

    public static function connect()
    {
        if (static::$pdo) {
            return static::$pdo;
        }

        $config = require __DIR__.'/../../config/database.php';

        try {
            static::$pdo = new PDO(
                "{$config['driver']}:host={$config['host']};dbname={$config['database']};charset={$config['charset']}",
                $config['username'],
                $config['password']
            );
            static::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return static::$pdo;
        } catch (\PDOException $e) {
            die('Could not connect to the database: ' . $e->getMessage());
        }
    }

    public static function query($sql, $params = [])
    {
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
