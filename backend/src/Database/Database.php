<?php

namespace Database;

use mysqli;

  // static one instance example ->
            // https://github.com/Dmitrijs1710/Crypto_market/blob/main/app/Database.php
class Database
{
    private static $connection = null;

    public static function get()
    {
        if (self::$connection === null) {
            self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // self::$connection->set_charset('utf8mb4'); optional
            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }

    public static function close()
    {
        if (self::$connection !== null && self::$connection) {
            self::$connection->close();
        }
        self::$connection = null;
    }
};
