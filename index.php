<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}
switch ($method) {
    case 'GET':
        if(isset($_GET['id'])){
            include_once 'src/read_single.php'; // fetch single
        } else {
            include_once 'src/read.php'; //fetch all
        }
        break;

    case 'POST':
        include_once 'src/create.php'; // Create a new category
        break;
    
    case 'PUT':
            include_once 'src/update.php'; // Update a category
            break;
    
        case 'DELETE':
            include_once 'src/delete.php'; // Delete a category
            break;
    
        default:
            echo json_encode(['message' => 'Method Not Allowed']);
            break;
    }
