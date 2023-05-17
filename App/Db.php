<?php

namespace App;

class Db
{

    protected $dbh;
    protected static $instance;
    public static $countSql = 0;
    public static $queries = [];

    public function __construct()
    {
        $config = (include __DIR__ . '/config.php')['db'];
        $servername = $config['servername'];
        $username = $config['username'];
        $password = $config['password'];
        $database = $config['database'];
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        $this->dbh = new \PDO("mysql:host=$servername;dbname=$database", $username, $password, $options);
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function execute($sql, $data = [])
    {
        self::$countSql++;
        self::$queries[] = $sql;
        $sth = $this->dbh->prepare($sql);
        return $sth->execute($data);
    }

    public function query($sql, $data = [], $class, $assocc = false)
    {
        self::$countSql++;
        self::$queries[] = $sql;
        $sth = $this->dbh->prepare($sql);
        $res = $sth->execute($data);
        if (false === $res) {
            throw new DbException("Запрос '$sql' не может быть выполнен");
        }
        if ($assocc) {
            return $sth->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
        }
    }

    public function getLastId()
    {
        return $this->dbh->lastInsertId();
    }
}
