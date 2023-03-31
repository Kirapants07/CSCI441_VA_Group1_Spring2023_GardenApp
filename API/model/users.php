<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

include_once 'userData.php';
include_once '../../functions/globalCUD.php';

class users{

    //database connection and table name
    private $conn;
    private $tableName = "users";

    private $userData;

    private $globalCUD;

    //object properties
    private $id;

    //constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db; // <- should have passed in the ADMIN db connection

        $this->userData = new userdata($db);
        $this->globalCUD = new globalCUD();
    }

    public function getConn() {
        return $this->conn;
    }

    function read($un) {
        //Note: This endpoint will return all user data except the password, this is by design.
        //Refer to api documentation for further specifics

        $query = 'SELECT id, userName, email, firstName, lastName, fullName, isRemovedFlag, 
                         hasAccessFlag, isAdminFlag, createdDate, lastModifiedDate
                    FROM users
                    WHERE userName = "'.$un.'"';

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        $num = $stmt->rowCount();

        //check if more than 0 record found
        if($num>0){
            //arm array
            $output_arr = array();

            //retrive arm table conents
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                
                //extract row
                extract($row);
                $item = array(
                    "id" => $id,
                    "userName" => $userName,
                    "email" => $email,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "fullName" => $fullName,
                    "isRemovedFlag" => $isRemovedFlag,
                    "hasAccessFlag" => $hasAccessFlag,
                    "isAdminFlag" => $isAdminFlag,
                    "createdDate" => $createdDate,
                    "lastModifiedDate" => $lastModifiedDate,
                    "userData" => $this->userData->read($id)
                );

                array_push($output_arr, $item);
            }

            return $output_arr;
        }
        else {
            return null;
        }
    }

    function create($array) {

        ///AUTH PASSWORD PREP
            //Until auth is done properly, I will be storing string passwords in database.
        //END AUTH PASSWORD PREP

        //Check that your user already exist!
        if(array_key_exists('userName', $array) && $this->userExists($array['userName'])){ 
                
            $currRet['success'] = "false";
            $currRet['message'] = "User already exists. Cannot create duplicate users.";

            return $currRet;

        }
        else{
            //Write new user to admin.users
            return $this->globalCUD->CreateGlobal($array, $this->conn, $this->tableName, $this->id);
        }
    }

    function update($array) {
        
        $this->id = $array['id'];
        
        if(array_key_exists('password', $array)) {
            ///AUTH PASSWORD PREP

            //END AUTH PASSWORD PREP
        }
        
        //Check that your user actually exist!
        if(array_key_exists('id', $array) && !id_Exists($array['id'], "users", $this->conn)){ 
                
            $currRet['success'] = "false";
            $currRet['message'] = "apiuser id Not Found";

            return $currRet;

        }
        else{

        if(array_key_exists('userData', $array)) {
            if($this->userData->read($this->id) != null) {
                $this->userData->update($this->id, $array['userData']);
            }
            else {
                $this->userData->create($this->id, $array['userData']);
            }
        }
            
            return $this->globalCUD->UpdateGlobal($array, $this->conn, $this->tableName);
        }

    }

    private function userExists($userName) {
        $query = 'SELECT * 
                    FROM users 
                    WHERE userName = "'.$userName.'"';
    
        //prepare query statement
        $stmt = $this->conn->prepare($query);
    
        //execute query
        $stmt->execute();
        $num = $stmt->rowCount();
    
        if($num >0) {
            return true;
        }
        else {
            return false;
        }
    }
}