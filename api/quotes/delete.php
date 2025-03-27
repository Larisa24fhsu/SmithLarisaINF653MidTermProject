<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: DELETE');
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

$quote->id = $data->id;

//Create post
if($quote->delete()){
    echo json_encode([
        'id' => $quote->id,
        'message' => 'Quote Deleted'
    ]);
} else {
    echo json_encode([
        'message' => 'Quote Not Deleted'
    ]);
}

//all functions tested and functioning