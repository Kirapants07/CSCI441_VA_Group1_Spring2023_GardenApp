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

function readWhereClause($table)
{   
    //$table is an optional paramter that only needs to be provided when using . notation in the query with JOIN statements
    //exclRmvFlag is provided when the API request wants to exclude results where isRemovedFlag is NOT "1"

    //This is utilized for allowing custom filters by API when they exist as part of a join and not the default table
    $lookUp = array(
        "exclRmvFlag" => array("")
    ); 

    //Table => Column names
    //This list includes all table name, column combos that are permitted to be queried via URL params on an API request
    $allowWhereArgs = array(
        "zipcode" => array("id", "zipcode"),
        "plantingzone" => array("id", "number"),
        "plant" => array("id", "name", "pluralName", "type")
    );

    $where_args = array();
    foreach ($_GET as $key=>$val) {
        if(in_array($key, $allowWhereArgs[$table])) {
            if ($val != "" && $key != "table") {
                if(!in_array($table, $lookUp["exclRmvFlag"]) && $key == "exclRmvFlag" && $val == "true") {
                    $where_args[] = 'isRemovedFlag <=> "0" OR isRemovedFlag <=> NULL OR isRemovedFlag <=> ""';
                }
                else if($table == null) {
                    $where_args[] = $key.'="'.$val.'"';
                }
                else if(array_key_exists($table, $lookUp) && !array_key_exists($key, $allowWhereArgs[$table])) {
                    if(!in_array($key, $lookUp[$table])) {
                        $where_args[] = $table.'.'.$key.'="'.$val.'"';
                    }
                    else {
                        $where_args[] = $key.'="'.$val.'"';
                    }
                }
                else {
                    $where_args[] = $table.'.'.$key.'="'.$val.'"';
                }
            }
        }
    } 

    if(!empty($where_args)) {
        $output = implode(' OR ', $where_args);
    }
    else {
        $output = null;
    }

    return $output;
}