<?php

namespace App\Core;
use PDO;
use PDOException;
class Db extends PDO
{

    private const DB_USER = 'root';
    private const DB_PASS = '';
    private const DB_NAME = 'testdb';
    private const DB_HOST = 'localhost';
    protected static $instance;

    private function __construct()
    {
        $dns = 'mysql:dbname=' . self::DB_NAME . ';host=' . self::DB_HOST;

        try {
            parent::__construct($dns, self::DB_USER, self::DB_PASS);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Erreur:" . $e->getMessage();
        }
    }
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}