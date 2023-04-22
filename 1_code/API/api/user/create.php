<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }
    $returnArray = array();
    if(array_key_exists('data', $data2) && sizeof($data2['data']) == 1)
    {
        $adminDB = new Database("userAdmin"); //Establish DB
        $admin = $adminDB->connect(); //Get connection
        //$armMany = array();
        

        $users = new users($admin);

        array_push($returnArray, $users->create($data2['data'][0]));

        if($returnArray[0]['success'] == "true")
        {
            //set response code - 200 Created
            http_response_code(201);

            echo json_encode($returnArray);
        }
        else 
        {
            //set response code - 400 bad request
            http_response_code(400);

            echo json_encode($returnArray);
        }
    }
    else{
        //Tell the user the data is incomplete
        //set response code - 400 bad request
        http_response_code(400);
        
        //tell the user
        echo json_encode(array("message" => "Incorrect data provided."));
    }
    //exit();
?>
