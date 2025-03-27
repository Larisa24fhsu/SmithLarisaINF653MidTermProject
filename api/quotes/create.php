<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$quote = new Quote($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

//Create post
if($quote->create()){
      // Return the created quote data with ID
      echo json_encode([
        'id' => $quote->id, 
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id
    ]);
} else {
    echo json_encode(
        array('message' => 'Quote Not Added')
    );
}

// all functions tested and working