<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }
       
    try{
        $plantgrowingrelationship = new plantgrowingrelationship($plants);
        
        $output = $plantgrowingrelationship->read(readWhereClause("plantgrowingrelationship"));

        if($output != null) {
            //set response code - 200 OK
            http_response_code(200);
            echo json_encode($output);
        }
        else {
            //set response code - 404 not found
            http_response_code(404);

            //tell the user no arm found
            echo json_encode(array("message" => "plantgrowingrelationship not found"));
        }
    } catch (Exception $e) {
        //set response code - 400 bad request
        http_response_code(400);
        echo json_encode(array('message' => $e->getMessage()));
    }
    exit();

?>