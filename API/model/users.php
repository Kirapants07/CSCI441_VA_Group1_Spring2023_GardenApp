<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

include_once '../../functions/globalCUD.php';

class users{

    //database connection and table name
    private $conn;
    private $tableName = "users";
    private $pepper = "UNIQUE PASSWORD PEPPER GOES HERE, I KNOW THIS IS OVERKILL";

    //object properties
    private $id;

    //constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db; // <- should have passed in the ADMIN db connection
    }

    public function getConn() {
        return $this->conn;
    }

    function create($array) {

        //need to pepper and hash the provided password for database storage
        $this->passwordPrep($array);

        //Check that your user already exist!
        if(array_key_exists('userName', $array) && $this->userExists($array['userName'])){ 
                
            $currRet['success'] = "false";
            $currRet['message'] = "User already exists. Cannot create duplicate users.";

            return $currRet;

        }
        else{
            //Write new user to admin.users
        }
    }

    function update($array) {
        
        //need to pepper and hash the provided password for database storage
        if(array_key_exists('password', $array)) {
            $this->passwordPrep($array);
        }
        
        //Check that your user actually exist!
        if(array_key_exists('id', $array) && !id_Exists($array['id'], "apiusers", $this->getConn())){ 
                
            $currRet['success'] = "false";
            $currRet['message'] = "apiuser id Not Found";

            return $currRet;

        }
        else{

            $this->id = $array['id'];
            
            //Update user in admin.users
        }

    }
    
    private function passwordPrep(&$array) {
        //Takes provided password and preps for data base entry, modifies array with correct column name as well

        //https://www.php.net/manual/en/function.password-hash.php
        //https://www.php.net/manual/en/faq.passwords.php

        $pw_peppered = hash_hmac("sha256", $array['password'], $this->pepper);
        $hashed_password = password_hash($pw_peppered, PASSWORD_DEFAULT);

        $array['passwordHash'] = $hashed_password;
        unset($array['password']);
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