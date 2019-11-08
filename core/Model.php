<?php


namespace core;

use components\DB;
use PDO;


abstract class Model extends DB
{
    public static function create(array $data)
    {
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));

        $query = self::getConnection()->prepare("INSERT INTO "  . self::getTableName() . "({$columns}) VALUES ({$values})");
        $query->execute(array_values($data));

        return self::getConnection()->lastInsertId();
    }

    public static function update($id, array $data)
    {
        $columns = implode('= ?, ', array_keys($data)) . '= ?';
        $query = self::getConnection()->prepare("UPDATE " . self::getTableName() . " SET $columns WHERE id = ?");

        $realValues = array_values($data);
        $realValues[] = $id;

        $query->execute($realValues);
    }

    public static function all()
    {
        $items = [];
        $result = self::getConnection()->query("SELECT * FROM " . self::getTableName());
        $result->setFetchMode(PDO::FETCH_ASSOC);

        if ($result) {
            foreach ($result as $row) {
                $items[] = $row;
            }
        }

        return $items;
    }

    public static function count()
    {
        $query = self::getConnection()->prepare("SELECT COUNT(*) FROM " . self::getTableName());
        $query->execute();

        return $query->fetchColumn();
    }

    public static function findOneById($id)
    {
        $query = self::getConnection()->prepare("SELECT * FROM " . self::getTableName() ." WHERE id = :id LIMIT 1");
        $query->execute(['id' => $id]);

        return $query->fetchObject();
    }

    private static function getTableName()
    {
        $modelPath = get_called_class();
        return $modelPath::$table;
    }
}