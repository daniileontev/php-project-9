<?php

namespace Hexlet\Code;

final class DataBaseConnection
{
    /**
     * Connection
     * тип @var
     */
    private static ?DataBaseConnection $conn = null;

    public function connect()
    {
        $file = realpath(__DIR__ . '/database.ini');
        if ($file === false) {
            $databaseUrl = parse_url($_ENV['DATABASE_URL']);
            $username = $databaseUrl['user']; // janedoe
            $password = $databaseUrl['pass']; // mypassword
            $host = $databaseUrl['host']; // localhost
            $port = $databaseUrl['port']; // 5432
            $dbName = ltrim($databaseUrl['path'], '/');
            $conStr = sprintf(
                "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
                $host,
                $port,
                $dbName,
                $username,
                $password
            );
        } else {
            $params = parse_ini_file('database.ini');
            if ($params) {
                $conStr = sprintf(
                    "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
                    $params['host'],
                    $params['port'],
                    $params['database'],
                    $params['user'],
                    $params['password']
                );
            } else {
                return false;
            }
        }
        $pdo = new \PDO($conStr);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function get()
    {
        if (null === self::$conn) {
            self::$conn = new self();
        }

        return self::$conn;
    }

    protected function __construct()
    {
    }
}