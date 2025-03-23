<?php
    class Database {
        private $host;
        private $port;
        private $db_name;
        private $username;
        private $password;
        private $conn;

        public function __construct() {
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->dbname = getenv('DBNAME');
            $this->host = getenv('HOST');
            $this->port = getenv('PORT');
        }
        public function connect(){ 
            if($this->conn){
                return $this->conn;
            } else {
                $dsn = "pgsql:host=" . getenv('HOST') . ";port=" . getenv('PORT') . ";dbname=" . getenv('DBNAME') . ";sslmode=require";
        
                try{
                    // Connect to PostgreSQL
                    $this->conn = new PDO($dsn, getenv('USERNAME'), getenv('PASSWORD'));
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    die('Connection Error: ' . $e->getMessage()); // Show actual connection error
                }
            }
        }
    }