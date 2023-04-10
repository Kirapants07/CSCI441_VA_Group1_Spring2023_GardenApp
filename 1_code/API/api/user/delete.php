<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }
       
    //set response code - 404 not found
    http_response_code(404);

    //tell the user no quotes found
    echo json_encode(array("message" => "Request type <DELETE> not found."));

    exit();
?>
