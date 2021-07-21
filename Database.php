<?php
require __DIR__ . "/Config.php";

class Database
{
    private static $con;

    private function __construct()
    {
        $host = Config::DB_HOST;
        $dbName = Config::DB_NAME;
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";

        try {
            self::$con = new PDO($dsn, Config::DB_USERNAME, Config::DB_PASSWORD);
        } catch (PDOException $e) {
            die("Cannot connect to database");
        }
        
        // Set emulate prepare to false so we get back the correct datatypes (like int) from the db
        self::$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // We only need column names from the db, not the default both column names and indexes
        self::$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    }

    public static function getInstance()
    {
        if (self::$con === null) new Database();
        return self::$con;
    }
}