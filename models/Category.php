<?php
class Category{
    private $conn;
    private $table = 'categories';

    //Category properties
    public $id;
    public $category;

    //constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    //get quotes
    public function read($id = null, $category = null) {
        //start query
        $query = "SELECT 
                    id, 
                    category
                FROM 
                    categories"; 
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt;
    }

    public function read_single(){
        $query = "SELECT
                    id,
                    category
                FROM
                    ". $this->table. "
                WHERE id = :id LIMIT 1";

         //prepared statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        //execute the query
        $stmt->execute();

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Populate the object properties
            $this->id = $row['id'];
            $this->category = $row['category'];
            return true; // Return true when category is found
        } else {
            return false; // Return false if category not found
        }
    }
    
     //add category
     public function create() {
        //create query
        $query = 'INSERT INTO ' . 
                $this->table . '
            (category) VALUES (:category)';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        //Bind Data
        $stmt->bindParam(':category', $this->category);
       
        // Execute the query and check if successful
         if ($stmt->execute()) {
        // Get the last inserted ID to return
        $this->id = $this->conn->lastInsertId();
        return true;
    }

     return false;
    }

    //add category
    public function update() {
        //create query
        $query = 'UPDATE ' . 
                $this->table . '
            SET
              category = :category
            WHERE
                id = :id';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return [
                'id' => $this->id,
                'category' => $this->category
            ];
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
        }
     //Delete category
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
