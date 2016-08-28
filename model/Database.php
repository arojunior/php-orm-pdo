<?php

class Database
{
    protected $conn;

    public function __construct()
    {
        $config = parse_ini_file('config.ini');

        $this->conn = new \PDO("mysql:host={$config['db_host']};".
                                "dbname={$config['db_name']}",
                                $config['db_user'],
                                $config['db_pass']
                            );
    }
}
