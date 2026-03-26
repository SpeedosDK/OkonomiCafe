<?php
require_once __DIR__ . '/config.php';

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {

            $config = loadConfig();

            self::$instance = new PDO(
                "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']};charset=utf8mb4",
                $config['DB_USER'],
                $config['DB_PASS']
            );

            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}
