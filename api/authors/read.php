<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Author.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$author = new Author($db);

//Quote query
$result = $author->read();
//Get row count
$num = $result->rowCount();

//Check if any quotes
if($num>0){
    $authors_arr = array();

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $author_item = array(
            'id'=>$id,
            'author'=>$author
        );
        //Push to "data"
        array_push($authors_arr, $author_item);
 
    }
    //Turn to JSON & output
    echo json_encode($authors_arr);
} else {
    //No posts
    echo json_encode(
        array('message' => 'No Authors Found')
    );
}

// all functions tested and working