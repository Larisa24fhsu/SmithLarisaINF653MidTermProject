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

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$quote = new Quote($db);

//Check for query parameters
$id = isset($_GET['id']) ? $_GET['id'] : null;
$author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

//Quote query
$result = $quote->read();
//Get row count
$num = $result->rowCount();

//Check if any quotes
if($num>0){
    $quotes_arr = array();
    $quotes_arr['data']=array();

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $quote_item = array(
            'id'=>$id,
            'quote'=>$quote,
            'author'=>$author,
            'category'=>$category
        );
        //Push to "data"
        array_push($quotes_arr['data'], $quote_item);
 
    }
    //Turn to JSON & output
    echo json_encode($quotes_arr);
} else {
    //No posts
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}


// all functions tested and working