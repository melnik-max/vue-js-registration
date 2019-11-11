<?php


namespace components;

use PDO;


abstract class DB
{
    private static $db;

    public static function getConnection() {
        if (!(self::$db instanceof PDO)) {
            self::$db = self::setConnection();
        }
        return self::$db;
    }

    private static function setConnection()
    {
        $params = include(ROOT . '/config/params.php');

        $connectionString = "mysql:host={$params['host']};dbname={$params['dbname']}";
        return new PDO($connectionString, $params['user'], $params['password']);
    }
}