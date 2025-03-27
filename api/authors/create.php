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
include_once '../../models/Author.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$author->author = $data->author;

if($author->create()){
    echo json_encode([
        'id' => $author->id,
        'author' => $author->author
    ]);
} else {
    echo json_encode(
        array('message'=> 'Author not added')
    );
}

//all functions tested and functioning