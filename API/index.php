<?php
// Headers
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
        if (isset($_GET['id'])) {
            if (strpos($uri, 'authors') !== false) {
                include_once __DIR__ . '/authors/read_single.php';
            } elseif (strpos($uri, 'categories') !== false) {
                include_once __DIR__ . '/categories/read_single.php';
            } else {
                echo json_encode(['error' => 'Invalid endpoint']);
            }
        } else {
            if (strpos($uri, 'authors') !== false) {
                include_once __DIR__ . '/authors/read.php';
            } elseif (strpos($uri, 'categories') !== false) {
                include_once __DIR__ . '/categories/read.php';
            } else {
                echo json_encode(['error' => 'Invalid endpoint']);
            }
        }
        break;

    case 'POST':
        if (strpos($uri, 'authors') !== false) {
            include_once __DIR__ . '/authors/create.php';
        } elseif (strpos($uri, 'categories') !== false) {
            include_once __DIR__ . '/categories/create.php';
        }
        break;

    case 'PUT':
        if (strpos($uri, 'authors') !== false) {
            include_once __DIR__ . '/authors/update.php';
        } elseif (strpos($uri, 'categories') !== false) {
            include_once __DIR__ . '/categories/update.php';
        }
        break;

    case 'DELETE':
        if (strpos($uri, 'authors') !== false) {
            include_once __DIR__ . '/authors/delete.php';
        } elseif (strpos($uri, 'categories') !== false) {
            include_once __DIR__ . '/categories/delete.php';
        }
        break;

    default:
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}
?>
