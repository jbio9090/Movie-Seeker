<?php

declare(strict_types=1);
namespace App\Models;

use Exception;


class Database {

    public static function connect(): \PDO {

        $dsn = "mysql:host=$_ENV[db_host];dbname=$_ENV[db_name];";

        return new \PDO(
            "mysql:host=$_ENV[db_host];port=$_ENV[port];dbname=$_ENV[db_name]",
            $_ENV['db_username'],
            $_ENV['db_password']
            ); 
    }
}