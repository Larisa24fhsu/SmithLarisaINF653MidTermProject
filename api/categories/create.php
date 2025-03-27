<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));


if (!isset($data->category)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$category->category = $data->category;

// Create the category
if ($category->create()) {
    // Return the created category data with ID
    echo json_encode([
        'id' => $category->id,
        'category' => $category->category
    ]);
} else {
    // If creation fails
    echo json_encode(['message' => 'Category Not Added']);
}
//all tested and functioning