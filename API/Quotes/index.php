<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Check if the request method is OPTIONS (CORS support)
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Normalize the URI for case insensitivity (convert to lowercase)
$uri = strtolower($uri);

// Route the request based on the URI and HTTP method
switch ($method) {
    case 'GET':
        if (isset($_GET['id']) || isset($_GET['author']) || isset($_GET['category'])) {
            include_once 'read_single.php'; // fetch single
        } else {
            include_once 'read.php'; // fetch all
        }
        break;

    case 'POST':
        include_once 'create.php'; // Create a new category or entity
        break;
    
    case 'PUT':
        include_once 'update.php'; // Update an existing entity
        break;
    
    case 'DELETE':
        include_once 'delete.php'; // Delete an entity
        break;
    
    default:
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}

// Route for specific case-insensitive URIs
if (strpos($uri, '/api/quotes') !== false) {
    // Include the handler for quotes (standardized route)
    include_once 'quotes_handler.php';
} elseif (strpos($uri, '/api/categories') !== false) {
    // Include the handler for categories (standardized route)
    include_once 'categories_handler.php';
} else {
    // Default response for unrecognized routes
    echo json_encode(['message' => 'Route not found.']);
}
