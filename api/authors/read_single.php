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

//Instantiate author object
$author = new Author($db);

// Validate and set ID
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['message' => 'author_id Not Found']);
    exit();
}

$author->id = intval($_GET['id']);

//Get author
$author->read_single();

//create array
if (!empty($author->author)) {
    $author_arr = [
        'id' => $author->id,
        'author' => $author->author
    ];
    echo json_encode($author_arr);
} else {
    // If not found, return JSON response
    echo json_encode(['message' => 'author_id Not Found']);
}

// all functions tested and working
