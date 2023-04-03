<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }
       
    try{
        if(array_key_exists('username', $_GET)) {
            $users = new users($admin);
            
            $output = $users->read($_GET['username']);

            if($output != null) {
                //set response code - 200 OK
                http_response_code(200);
                echo json_encode($output);
            }
            else {
                //set response code - 404 not found
                http_response_code(404);

                //tell the user no arm found
                echo json_encode(array("message" => "user not found"));
            }
        }
        else {
            //set response code - 400 bad request
            http_response_code(400);

            //tell the user no arm found
            echo json_encode(array("message" => "username must be provided"));
        }
    } catch (Exception $e) {
        //set response code - 400 bad request
        http_response_code(400);
        echo json_encode(array('message' => $e->getMessage()));
    }
    exit();

?>