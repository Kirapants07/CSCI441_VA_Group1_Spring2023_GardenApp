<?php 

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

//Grabs a UUID from the server and returns it, this is used for creating
function get_UUID($conn)
{
    //Generate UUID and return to object
    $query = 'SELECT UUID()';
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_LAST);

    return $row[0];
}

//Used for checking if an ID exists within a table before attempting to add
function id_Exists($id, $table, $conn)
{
    //$id should be an int
    //$table should only be either 'category' or 'sponsor', for example

    $query = 'SELECT id FROM '.$table.' WHERE id = "'.$id.'"';

    //prepare query statement
    $stmt = $conn->prepare($query);

    //execute query
    $stmt->execute();

    if($stmt->rowCount() > 0){
        return true;
    }
    else{
        return false;
    }
}

function idTableLookUp($id, $table, $conn) 
{
    //This is written to pull a specific item from any table based on its id

    //Write and prepare query
    $query = 'SELECT *
                FROM '.$table.'
                WHERE id = \''.$id.'\'';

    //prepare query statement
    $stmt = $conn->prepare($query);

    //execute query
    $stmt->execute();
    
    if($stmt->rowCount() > 0)
    {
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    else{
        return null;
    }
}

function checkInputType($input)
{
    if($input != null){

        if(isJson($input)){
    
            return;
        }
        else {
            http_response_code(400);
    
            echo json_encode(array("message" => "Provided input is not JSON format. Ensure data is also of expected type array."));

            exit();
        }
    }
    else {
        http_response_code(400);
    
        echo json_encode(array("message" => "No input provided."));

        exit();
    }
}

function isJson($string) 
{
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}