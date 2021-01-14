<?php


namespace LightFramework\Database;


class DatabaseConnection
{
    protected static ?\PDO $conn = null;

    public static function getConnection(): \PDO {
        if(!self::$conn) {
            self::$conn = new \PDO($_ENV['DATABASE_DSN'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD']);
            if($_ENV["APP_MODE"] === "DEV") {
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
        }
        return self::$conn;
    }
}