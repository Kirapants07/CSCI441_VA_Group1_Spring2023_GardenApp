<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

include_once '../../config/errorLogs/errorLogs.php';

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