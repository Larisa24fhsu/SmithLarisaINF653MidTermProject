<?php

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
        $query = "SELECT id, author FROM authors WHERE id = :id LIMIT 1";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            $this->id = $row['id'];
            $this->author = $row['author'];
        } else {
            // Return JSON directly instead of just echoing inside this function
            echo json_encode(['message' => 'author_id Not Found']);
            exit();  // Stop further execution to prevent invalid JSON output
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

       // Check if author exists
       public function checkAuthorExists($author_id) {
        $query = "SELECT id FROM " . $this->table . " WHERE id = :author_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

}