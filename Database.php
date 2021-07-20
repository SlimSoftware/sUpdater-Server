<?php
require __DIR__ . "/Config.php";

class Database
{
    private static $con;

    private function __construct()
    {
        self::$con = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME . ";charset=utf8mb4", Config::DB_USERNAME, Config::DB_PASSWORD);
        self::$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // needed so we get back the correct datatypes from the db
        self::$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // we only need column names from the db, not the default both column names and indexes
    }

    public static function getInstance()
    {
        if (self::$con === null) new Database();
        return self::$con;
    }
}