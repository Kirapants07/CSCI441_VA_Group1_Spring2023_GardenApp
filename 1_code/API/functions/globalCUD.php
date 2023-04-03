<?php 

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

class globalCUD{

    private $requireParam = array(
        "users" => array("userName", "passwordHash", "email", "firstName", "lastName", "fullName", "hasAccessFlag")
    );
    
    private $optionalParam = array(
        "users" => array("isRemovedFlag")
    );

    function CreateGlobal($array, $conn, $table, &$id)
    {
        $currRet = array(
            "success" => "",
            "message" => "",
            "data" => null,
        );
        
        if(array_key_exists($table, $this->requireParam)){
            $id = get_UUid($conn);

            $queryPieces = $this->requiredParametersCreation($table, $array);

            if($queryPieces != null)
                try {
                    $query = 'INSERT INTO '.$table.'
                                (id, '.$queryPieces[0].')
                            VALUES
                                ("'.$id.'", '.$queryPieces[1].')';

                    //prepare query statement
                    $stmt = $conn->prepare($query);

                    //execute query
                    $stmt->execute();
            
                    $currRet['success'] = "true";
                    $currRet['message'] = "Successfully created ".$table;
                    $currRet['data'] = array("id" => $id) + $array;

                    return $currRet;

                } catch (Exception $e) {

                    logQueryError($query, $e->getMessage());

                    $currRet['success'] = "false";
                    $currRet['message'] = $e->getMessage();

                    return $currRet;

                }
            else{

                if(array_key_exists($table, $this->optionalParam)) {
                    $errAdd = " and OPTIONAL inputs: ".implode(", ", $this->optionalParam[$table]);
                }
                else {
                    $errAdd = "";
                }

                $currRet['success'] = "false";
                $currRet['message'] = "Incorrect provided paramters! For ".$table." REQUIRED inputs: ".implode(", ", $this->requireParam[$table]).$errAdd;

                return $currRet;

            }
        }
        else{

            $currRet['success'] = "false";
            $currRet['message'] = "Invalid table name provided: ".$table;

            return $currRet;

        }
    }

    function requiredParametersCreation($table, $data) // <-- used for CREATE
    {
        //Search through predefined k,v pairs for given table
        //Check that data provided has all required inputs for given table
        //Additionally verifies that no additional OPTIONAL params are provided
        
        $output = array();
        $optPar = true;
        $requiredCount = 0; // <-- counts number of required fields and ensures they are all present
        $args0 = array();
        $args1 = array();

        foreach ($data as $key => $value)
        {
            if(in_array($key, $this->requireParam[$table])){
                $requiredCount++;
            }
            else if(array_key_exists($table, $this->optionalParam)){
                if(!in_array($key, $this->optionalParam[$table])){
                    $optPar = false;
                    break;
                }
            }

            array_push($args0, $key);
            array_push($args1, '"'.$value.'"');
        }

        if(sizeof($this->requireParam[$table]) == $requiredCount && $optPar){

            array_push($output, implode(', ', $args0));
            array_push($output, implode(', ', $args1));

            return $output;
        }
        else {
            return null;
        }
    }

    function DeleteGlobal($array, $conn, $table)
    {
        $currRet = array(
            "success" => "",
            "message" => "",
            "data" => null,
        );

        if(array_key_exists('id', $array))
        {
            $id = $array['id'];

            if(id_Exists($id, $table, $conn))
            {
                try {
                        
                    $query = 'DELETE FROM '.$table.' WHERE id = "'.$id.'"';

                    //prepare query statement
                    $stmt = $conn->prepare($query);

                    //execute query
                    $stmt->execute();

                    $currRet['success'] = "true";
                    $currRet['message'] = "Successfully deleted ".$table;
                    $currRet['data'] = array("id" => $id);

                    return $currRet;
                        
                } catch (Exception $e) {

                    logQueryError($query, $e->getMessage());

                    $currRet['success'] = "false";
                    $currRet['message'] = $e->getMessage();

                    return $currRet;
                }
            }
            else{

                $currRet['success'] = "false";
                $currRet['message'] = $table."id not found";

                return $currRet;
            }
        }
        else {

            $currRet['success'] = "false";
            $currRet['message'] = "Missing Required Parameters. An id field is required.";

            return $currRet;
        }
    }

    function UpdateGlobal($array, $conn, $table)
    {
        $currRet = array(
            "success" => "",
            "message" => "",
            "data" => null,
        );

        if(array_key_exists('id', $array))
        {
            $id = $array['id'];

            if(id_Exists($id, $table, $conn)) {

                try {
                    $query = 'UPDATE '.$table.' 
                                SET '.$this->updateQueryCompile($array).'
                                WHERE id = "'.$id.'"';

                    //prepare query statement
                    $stmt = $conn->prepare($query);

                    //execute query
                    $stmt->execute();
                    
                    $currRet['success'] = "true";
                    $currRet['message'] = "Successfully updated ".$table;
                    $currRet['data'] = $array;

                    return $currRet;

                } catch (Exception $e) {

                    logQueryError($query, $e->getMessage());
                    
                    $currRet['success'] = "false";
                    $currRet['message'] = $e->getMessage();

                    return $currRet;
                }
            }
            else {

                $currRet['success'] = "false";
                $currRet['message'] = $table."id not found";

                return $currRet;

            }
        }
        else {

            $currRet['success'] = "false";
            $currRet['message'] = "Missing Required Parameters. An id field is required.";

            return $currRet;
        }
    }

    private function id_used($id, $table, $column, $conn)
    {
        $query = 'SELECT '.$column.' FROM '.$table.' WHERE '.$column.' = "'.$id.'"';

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

    
    private function updateQueryCompile($data)
    {
        //This is not necessary yet, but it may be for later
        //Will clean all tags from each value.

        $set= array();
        foreach ($data as $key => $value)
        {
            if($key != "id" && $key != "userData"){
                $set[] = $key.' ="'.$value.'"';
            }
        }

        $output = implode(', ', $set);

        return $output;
    }
}