<?php
/**
 * MySql PDO
 */

namespace DB;

class Pdo
{
    public static $db = null;

    public static function getDb()
    {
        return self::$db;
    }

    public static function setDb($cfg)
    {
        try {
            $dsn = "mysql:host={$cfg['host']};port={$cfg['port']};dbname={$cfg['db']}";

            $dbh = new \PDO($dsn, $cfg['username'], $cfg['password']);
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$db = $dbh;
            return self::$db;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
