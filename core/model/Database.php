<?php

namespace SimpleORM\core\model;

class Database
{
    protected $conn;

    /*
    * create database connection
    */
    public function __construct($config = null)
    {
        if (empty($config)) {
            $config = parse_ini_file('config.ini');
        }

        $this->conn = new \PDO("mysql:host={$config['db_host']};".
                                "dbname={$config['db_name']}",
                                $config['db_user'],
                                $config['db_pass']
                            );
    }
}
