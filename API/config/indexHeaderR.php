<?php

    /// This is a generic header that covers all endpoints that may need to read ONLY
    /// Written in a generic way to be called as require_once() in each index file 
    /// inside of each sub folder. Since these files are often repetitive this keeps
    /// debugging easier to follow and less duplcation of error.


    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

    //This acts as a file to house the global header included in ALL index.php files on all end points

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($requestMethod === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    }

    // include database and object files
    include_once '../../config/database.php';
    include_once '../../functions/myFunctions.php';
    include_once '../../config/errorLogs/errorLogs.php';

    if($requestMethod != "GET") {
        checkInputType(file_get_contents("php://input"));
    }

    //$adminDB = new Database("userAdmin");
    $plantData = new Database("plantData");

    //$admin = $adminDB->connect();
    $plants = $plantData->connect();

    //Auth Time
    //require_once 'authExecute.php';

    $id = null;

    if ($requestMethod === 'GET') {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    }

    // Parameters sent with POST, PUT, and DELETE methods
    $data = json_decode(file_get_contents("php://input"));
    if ($requestMethod !== 'GET') { 

        if(!is_array($data->data)) {
            //set response code - 404 not found
            http_response_code(400);

            //tell the user no quotes found
            echo json_encode(array("message" => "data is not an array"));

            exit();
        }
    }
    
    //New array of decoded JSON data
    $data2 = json_decode(file_get_contents("php://input"),true);


    if($requestMethod == "GET"){
        include_once("read.php");
    }
    else{
        //set response code - 404 not found
        http_response_code(404);

        //tell the user no quotes found
        echo json_encode(array("message" => "Request type <".$requestMethod."> not found."));
    }