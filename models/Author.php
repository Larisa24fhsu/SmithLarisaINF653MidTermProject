<?php

include_once __DIR__ . '../config/Database.php';

class Author{
    private $conn;
    private $table = 'authors';

    //Author properties
    public $author;
    public $id;

    //constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    //get quotes
    public function read($id = null, $author = null) {
        //start query
        $query = "SELECT 
                    id, 
                    author 
                FROM 
                    authors"; 
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt;
    }

    //get single author
    public function read_single(){
        $query = "SELECT
                    id,
                    author
                FROM
                    authors
                WHERE id = :id LIMIT 1";

         //prepared statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1, $this->id);

        //execute the query
        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->author = $row['author'];
        } else {
            echo json_encode(['message' => 'No authors found']); // Return error message if no author exists
        }
    }

    //add author
    public function create() {
        //create query
        $query = 'INSERT INTO ' . 
                $this->table . '
            (author) VALUES (:author)';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        //Bind Data
        $stmt->bindParam(':author', $this->author);
       
        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

     return false;

    }

    //update author
    public function update() {
        //create query
        $query = 'UPDATE ' . 
                $this->table . '
            SET
                author = :author
            WHERE
                id = :id';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind Data
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);
       
        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

     return false;

    }

    //Delete author 
    public function delete() {
        //Create query
        $query = 'DELETE FROM ' .
            $this->table .
            ' WHERE 
                id = :id';

        //Prepare statement        
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

     return false;
   
    }

}