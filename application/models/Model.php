<?php

class Model {

    protected $db;
    protected $st;

    public function __construct() {
        // Connect to the database
        $this->db = @new PDO('mysql:host=' . Config::$db['host'] . ';dbname=' . Config::$db['database'],
                             Config::$db['user'],
                             Config::$db['pass'],
                             array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
    }

    public function __destruct() {
        // Close the statement handle and database connection
        $this->st = null;
        $this->db = null;
    }

}