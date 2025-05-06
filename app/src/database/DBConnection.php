<?php

$db_config = require_once("database-properties.php");

class DBConnection
{
    private static ?PDO $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        global $db_config;
        if (self::$instance === null) {
            try {
                self::$instance = new PDO("{$db_config['db']}:host={$db_config['host']};dbname={$db_config['dbname']}", "{$db_config['user']}", "{$db_config['password']}");

                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Ошибка подключения: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    private function __clone()
    {
    }
    //!deserialization
    public function __wakeup()
    {
    }
}