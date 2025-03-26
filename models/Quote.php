<?php

include_once __DIR__ . '../config/Database.php';

class Quote{
    private $conn;
    private $table = 'quotes';

    //quote properties
    public $id;
    public $category_id;
    public $quote;
    public $author_id;


    //constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    //Get quotes 
    public function read(){
        //Create query
        $query = "SELECT 
                    q.id, 
                    q.quote, 
                    a.author, 
                    c.category
                FROM " . $this->table . " q
                JOIN
                    authors a ON q.author_id = a.id
                JOIN 
                    categories c ON q.category_id = c.id";
                
    //prepared statement
    $stmt = $this->conn->prepare($query);

    //execute the query
    $stmt->execute();

    return $stmt;
    }
    
    public function read_single(){
        $query = "SELECT
                    q.id, 
                    q.quote, 
                    a.author, 
                    c.category
                FROM 
                    " . $this->table . " q
                LEFT JOIN
                    authors a ON q.author_id = a.id
                LEFT JOIN 
                    categories c ON q.category_id = c.id";  

         // Check if an author or category filter is provided
        $conditions = [];
        if (!empty($this->id)) {
            $conditions[] = "q.id = :id";
        }
        if (!empty($this->author_id)) {
            $conditions[] = "q.author_id = :author_id";
        }
        if (!empty($this->category_id)) {
            $conditions[] = "q.category_id = :category_id";
        }

        //append conditions to query
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        //prepared statement
        $stmt = $this->conn->prepare($query);

         //bind parameters
         if (!empty($this->id)) {
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        }
         if (!empty($this->author_id)) {
            $stmt->bindParam(':author_id', $this->author_id);
        }
        if (!empty($this->category_id)) {
            $stmt->bindParam(':category_id', $this->category_id);
        }
        
        //execute the query
        $stmt->execute();

        // Fetch results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results ?: [];
        }

     //add quotes
     public function create() {
        //create query
        $query = 'INSERT INTO ' . 
                $this->table . '
            (quote, author_id, category_id) 
        VALUES (:quote, :author_id, :category_id)';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
 
        //Bind Data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

     return false;
    }

    //add quotes
    public function update() {
        //create query
        $query = 'INSERT INTO ' . 
                $this->table . '
            SET
                quote = :quote, 
                author_id = :author_id, 
                category_id = :category_id 
            WHERE
                id = :id';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
 
        //Bind Data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
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
