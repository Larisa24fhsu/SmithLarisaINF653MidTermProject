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

// Get category
$category->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(['message' => 'category_id Not Found']));

// Fetch category data
if($category->read_single()) {
    // Create array
    $category_arr = array (
        'id' => $category->id,
        'category' => $category->category
    );

    // Make JSON
    echo json_encode($category_arr);
} else {
    // If category does not exist, return a JSON response
    echo json_encode(['message' => 'category_id Not Found']);
}

// all functions tested and working