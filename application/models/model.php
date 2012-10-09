<?php

class Model {

    protected $db;
    protected $st;

    public function __construct() {
        // Connect to our database
        try {
            $this->db = new PDO('mysql:host=' . Config::$db['host'] . ';dbname=' . Config::$db['database'], Config::$db['user'], Config::$db['pass']); 
        } catch(PDOException $e) {
            throw new Exception('Failed to connect to database: ' . $e->getMessage());
        }
    }

    public function __destruct() {
        // Close the statement handle and database connection
        $this->st = null;
        $this->db = null;
    }

}