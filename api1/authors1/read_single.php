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

// Get author
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get author
$author->read_single();

//create array
$author_arr = array (
    'id' => $author->id,
    'category' => $author->author
);

//Make JSON
print_r(json_encode($author_arr));

// all functions tested and working
