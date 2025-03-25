<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Normalize the URI for case insensitivity (use Apache's .htaccess for case normalization)
if (strpos($uri, '/api/') === 0) {
    $uri = str_replace('/api/', '/API/', $uri); // Force all "/api/" to "/API/"
}

// Check if the request method is OPTIONS (CORS support)
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

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
if (strpos($uri, '/API/quotes') !== false) {
    // Handle the quotes route directly here
    // Example: get quotes, create quotes, etc.
    if ($method === 'GET') {
        // Fetch quotes logic
        include_once 'quotes/read.php';
    } elseif ($method === 'POST') {
        // Create new quote logic
        include_once 'quotes/create.php';
    }
} else {
    // Default response for unrecognized routes
    echo json_encode(['message' => 'Route not found.']);
}
