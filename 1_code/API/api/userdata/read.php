<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }
       
    try{
        if(array_key_exists('id', $_GET)) {
            $userdata = new userdata($admin);
            
            $output = $userdata->read($_GET['id']);

            if($output != null) {
                //set response code - 200 OK
                http_response_code(200);
                echo json_encode($output);
            }
            else {
                //set response code - 404 not found
                http_response_code(404);

                //tell the user no arm found
                echo json_encode(array("message" => "user id not found"));
            }
        }
        else {
            //set response code - 400 bad request
            http_response_code(400);

            //tell the user no arm found
            echo json_encode(array("message" => "user id must be provided"));
        }
    } catch (Exception $e) {
        //set response code - 400 bad request
        http_response_code(400);
        echo json_encode(array('message' => $e->getMessage()));
    }
    exit();

?>