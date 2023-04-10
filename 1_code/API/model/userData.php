<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

class userdata {

    //database connection and table name
    private $UserConn;
    private $tableName = "userdata";

    private $id;

    private $globalCUD;

    //object properties

    //constructor with $db as database connection
    public function __construct($dbus){
        $this->UserConn = $dbus;
        $this->globalCUD = new globalCUD();
    }

    function read($userid){
        //return the userdata column in text with a provided userid3

        $query = 'SELECT *
                    FROM userdata
                    WHERE userid = "'.$userid.'"';

        //prepare query statement
        $stmt = $this->UserConn->prepare($query);

        //execute query
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        else{
            return null;
        }
    }

    function create($array){
        
        //need to verify that user and plant exist before writing
        if((array_key_exists('userId', $array) && !$this->useridexists($array['userId'])) ||
           (array_key_exists('plantId', $array) && !$this->plantidexists($array['plantId']))) {
            
            $currRet['success'] = "false";
            $currRet['message'] = "userId or plantId are incorrect.";

            return $currRet;
        }
        else{
            //Write new user to admin.users
            return $this->globalCUD->CreateGlobal($array, $this->UserConn, $this->tableName, $this->id);
        }
    }

    function update($array){
        
        $this->id = $array['id'];

        //need to verify that user and plant exist before writing
        if((array_key_exists('userId', $array) && !$this->useridexists($array['userId'])) ||
           (array_key_exists('plantId', $array) && !$this->plantidexists($array['plantId']))) {
            
            $currRet['success'] = "false";
            $currRet['message'] = "userId or plantId are incorrect.";

            return $currRet;
        }
        else{
            //Write new user to admin.users
            return $this->globalCUD->UpdateGlobal($array, $this->UserConn, $this->tableName, $this->id);
        }
    }

    function delete($array){
        
        return $this->globalCUD->DeleteGlobal($array, $this->UserConn, $this->tableName);
    }

    private function useridexists($userid){
        $query = 'SELECT *
                    FROM useradmin.users
                    WHERE id = "'.$userid.'"';

        //prepare query statement
        $stmt = $this->UserConn->prepare($query);

        //execute query
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    private function plantidexists($plantid){
        $query = 'SELECT *
                    FROM plantdata.plant
                    WHERE id = "'.$plantid.'"';

        //prepare query statement
        $stmt = $this->UserConn->prepare($query);

        //execute query
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}