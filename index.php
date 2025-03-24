<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Get the HTTP method and request URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Handle CORS Preflight Requests
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Parse the URL to extract the route
$parsedUrl = parse_url($uri);
$path = trim($parsedUrl['path'], '/');
$segments = explode('/', $path);


// Determine the entity (quotes, authors, categories)
$resource = $segments[1] ?? null;
$id = $segments[2] ?? null; // If an ID is provided (e.g., api/quotes/5)

// Route API requests to the correct handler
switch ($resource) {
    case 'quotes':
        handleRequest('quotes', $method, $id);
        break;

    case 'authors':
        handleRequest('authors', $method, $id);
        break;

    case 'categories':
        handleRequest('categories', $method, $id);
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Resource not found"]);
        break;
}

/**
 * Function to handle API requests dynamically
 */
function handleRequest($resource, $method, $id)
{
    // Set the resource directory for quotes, authors, and categories
    $resourceDir = "api/$resource";

    switch ($method) {
        case 'GET':
            if ($id) {
                include_once "$resourceDir/read_single.php"; // Fetch single item (by ID)
            } else {
                include_once "$resourceDir/read.php"; // Fetch all items
            }
            break;

        case 'POST':
            include_once "$resourceDir/create.php"; // Create new entry
            break;

        case 'PUT':
            if ($id) {
                include_once "$resourceDir/update.php"; // Update specific entry (by ID)
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Missing ID for update"]);
            }
            break;

        case 'DELETE':
            if ($id) {
                include_once "$resourceDir/delete.php"; // Delete specific entry (by ID)
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Missing ID for deletion"]);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Method Not Allowed"]);
            break;
    }
}
?>
