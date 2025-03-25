<?php
    class Database {
        private $host;
        private $db_name;
        private $username;
        private $password;
        private $conn;

        public function __construct() {
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->dbname = getenv('DBNAME');
            $this->host = getenv('HOST');
        }
        public function connect(){ 
            if($this->conn){
                return $this->conn;
            } else {

                //$dsn = "pgsql:host=" . getenv('HOST') . ";dbname=" . getenv('DBNAME') . ";sslmode=prefer";
                $dsn = "pgsql:host={$this->host}; dbname={$this->db_name}";
        
                try{
                    // Connect to PostgreSQL
                    $this->conn = new PDO($dsn, getenv('USERNAME'), getenv('PASSWORD'));
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    return $this->conn; //ensure connection

                }catch(PDOException $e){
                    die('Connection Error: ' . $e->getMessage()); // Show actual connection error
                }
            }
        }
    }