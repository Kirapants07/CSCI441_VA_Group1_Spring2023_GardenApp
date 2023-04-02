<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

include_once('database.php');

class userAuth{
    
    private $pepper = "THIS IS THE USER AUTH PEPPER. ";

    function hashPass($password)
    {
        return hash_hmac("sha256", $password, $this->pepper);
        
    }

    function validateUser($enteredUsername, $enteredPass)
    {
        
            //Get user data
            $adminDB = new Database("userAdmin");
            $admin = $adminDB->connect();
            $query = 'SELECT userName, passwordHash
            FROM users
            WHERE userName = "'.$enteredUsername.'"';

            $statement = $adminDB->conn->prepare($query);

             //execute query
             $statement->execute();

            if($statement->rowCount() > 0)
                $user_info = $statement->fetchAll(\PDO::FETCH_ASSOC);
            else
                $user_info = null;
             
            //Hash Password
            $hashed_entered_pass = $this->hashPass($enteredPass);
            if($user_info != null){ 
                //Compare Hashed password to passwordHash
                if($user_info[0]['passwordHash'] == $hashed_entered_pass) { //If the passwords are the same
                    session_start();
                    $_SESSION["username"] = $enteredUsername;
                    return true;
                }
                else{ //If the passwords are not equal
                    return false;
                }
            }
            else{ //If user_data == null, return false
                return false;
            }
    
    }
}

class Auth {

    //database connection and table name
    private $conn;

    private $suppliedUserName;
    private $suppliedPassword;
    private $pepper = "UNIQUE PASSWORD PEPPER GOES HERE, I KNOW THIS IS OVERKILL";

    //constructor with $db as database connection
    public function __construct($db, $un, $pw){
        $this->conn = $db;
        $this->suppliedUserName = $un;
        $this->suppliedPassword = $pw;
    }

    public function getConn(){
        return $this->conn;
    }

    //Functions
    private function getUser(){
        //Query the database for the user provided and return the info needed to authenticate

        try {
            $query = 'SELECT * FROM apiusers WHERE userName = "'.$this->suppliedUserName.'"';

            //prepare query statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();
            $num = $stmt->rowCount();

        } catch (Exception $e) {

            logQueryError($query, $e->getMessage());

            //set response code - 401 not authorized
            http_response_code(400);

            //tell the user no quotes found
            echo json_encode(array("message" => "Query error."));

            exit();
        }

        if($num > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        else {
            return null;
        }
    }

    function authenticate(){
        //Returns a boolean,
        //True - continue, False, end instance

        $peppered_provided_pw = hash_hmac("sha256", $this->suppliedPassword, $this->pepper);

        $db_user_info = $this->getUser();

        if($db_user_info != null) {

            if($db_user_info[0]['passwordHash'] == crypt($peppered_provided_pw, $db_user_info[0]['passwordHash'])) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
}