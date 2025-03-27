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

if ($result) {
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo json_encode(['message' => 'category_id Not Found']);
}