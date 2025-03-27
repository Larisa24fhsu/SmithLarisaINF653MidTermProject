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

// Get category id from URL parameter
$category->id = isset($_GET['id']) ? $_GET['id'] : null;

// Check if the category id is provided
if ($category->id === null) {
    echo json_encode(['message' => 'category_id Not Found']);
    exit();
}


// Fetch single category
$result = $category->read_single();

// Check if category data was returned
if ($result) {
    // If category exists, return data
    $category_arr = [
        'id' => $category->id,
        'category' => $category->category
    ];
    echo json_encode($category_arr);
} else {
    // If category is not found, return an error message
    echo json_encode(['message' => 'category_id Not Found']);
}