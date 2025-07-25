<?php

declare(strict_types=1);
namespace App\Models;

use Exception;


class Database {

    public static function connect(): \PDO {
        return new \PDO(
            "mysql:host=$_ENV[db_host];port=3307;dbname=$_ENV[db_name]",
            $_ENV['db_username'],
            null
            ); 
    }
}