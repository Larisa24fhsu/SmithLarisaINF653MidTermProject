<?php
//Headers
header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }


include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);



// Validate input parameters
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$quote->id = intval($_GET['id']);

// Get single quote
$result = $quote->read_single();

// Check if any quotes exist
$result = $quote->read_single();

if ($result) {
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo json_encode(['message' => 'No Quotes Found']);
}

// all functions tested and working
