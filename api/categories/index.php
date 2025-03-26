<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With, Authorized');
    exit();
}
switch ($method) {
    case 'GET':
        if(isset($_GET['id'])){
            include_once 'read_single.php'; // fetch single
        } else {
            include_once 'read.php'; //fetch all
        }
        break;

    case 'POST':
        include_once 'create.php'; // Create a new category
        break;
    
    case 'PUT':
            include_once 'update.php'; // Update a category
            break;
    
        case 'DELETE':
            include_once 'delete.php'; // Delete a category
            break;
    
        default:
            echo json_encode(['message' => 'Method Not Allowed']);
            break;
    }
