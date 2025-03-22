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
include_once '../../models/Category.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate category object
$category = new Category($db);

//Get ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get category
$category->read_single();

//create array
$category_arr = [
    'id' => $category->id,
    'category' => $category->category
];

//Make JSON
print_r(json_encode($category_arr));


// all functions tested and working