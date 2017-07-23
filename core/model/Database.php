<?php

namespace SimpleORM\core\model;

abstract class Database
{
    protected   $conn;
    public      $db_config;

    /*
    * create database connection
    */
    public function __construct()
    {
        if (empty($this->db_config)) {
            $this->db_config = parse_ini_file('config.ini');
        }

        $this->conn = new \PDO("mysql:host={$this->db_config['db_host']};" .
                                "dbname={$this->db_config['db_name']}",
                                $this->db_config['db_user'],
                                $this->db_config['db_pass']
                            );
    }
}
