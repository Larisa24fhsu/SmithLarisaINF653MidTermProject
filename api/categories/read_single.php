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

// Validate and set ID
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['message' => 'category_id Not Found']);
    exit();
}

$category->id = intval($_GET['id']);

// Fetch single category
$result = $category->read_single();

// If category exists, return data
if (!empty($category->category)) {
    $category_arr = [
        'id' => $category->id,
        'category' => $category->category
    ];
    echo json_encode($category_arr);
} else {
    // If category is not found, return an error message
    echo json_encode(['message' => 'category_id Not Found']);
}