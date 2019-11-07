<?php


namespace components;

use PDO;


abstract class DB
{
    protected static $db;

    public static function getConnection()
    {
        $params = include(ROOT . '/config/params.php');

        $connectionString = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($connectionString, $params['user'], $params['password']);

        return $db;
    }
}