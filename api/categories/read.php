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
include_once '../../models/Category.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate quote object
$category = new Category($db);

//Quote query
$result = $category->read();
//Get row count
$num = $result->rowCount();

//Check if any quotes
if($num>0){
    $categories_arr = array();

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $categories_arr[] = array(
            'id'=>$id,
            'category'=>$category
        );
    }
    //Turn to JSON & output
    echo json_encode($categories_arr);
} else {
    //No posts
    echo json_encode(
        array('message' => 'No Categories Found')
    );
}

// all functions tested and working