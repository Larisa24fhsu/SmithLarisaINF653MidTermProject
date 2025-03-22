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
include_once '../../models/Category.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || empty($data->id)) {
    die(json_encode(["error" => "ID is required"]));
}

$category->id = $data->id;

//Create post
if($category->delete()){
    echo json_encode(
        array('message' => 'Category Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Deleted')
    );
}

//all tested and functioning

