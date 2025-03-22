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
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);



if (isset($_GET['id']) && !empty($_GET['id'])) {
    $quote->id = intval($_GET['id']);
}

if (isset($_GET['author']) && !empty($_GET['author'])) {
    $quote->author_id = intval($_GET['author']);
}

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $quote->category_id = intval($_GET['category']);
}


// Get quotes
$result = $quote->read_single();

// Check if any quotes exist
if (empty($result)) {
    echo json_encode(['message' => 'No quotes found.']);
    exit();
}

// Return JSON response
echo json_encode($result, JSON_PRETTY_PRINT);

// all functions tested and working
