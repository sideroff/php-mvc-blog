<?php


class BaseModel
{
    protected static $db;

    public function __construct()
    {
        if(!isset($db)) {
            // Create connection
            self::$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASS, DB_NAME);
            self::$db->set_charset('utf8');

            // Check connection
            if (self::$db->connect_error) {
                die("Connection failed: " . self::$db->connect_error);
            }
        }
    }

}