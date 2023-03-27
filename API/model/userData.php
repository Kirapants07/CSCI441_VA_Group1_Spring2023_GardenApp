<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

class userdata {

    //database connection and table name
    private $conn;
    private $tableName = "userdata";

    //Class is only to be used by the users class to read and write user data to this table.
    //Data structure was split to ensure that the base user table isnt bloating by XAML style user preferences

    //object properties

    //constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function getConn(){
        return $this->conn;
    }

    function read($userid){
        //return the userdata column in text with a provided userid3

        $query = 'SELECT userData
                    FROM userdata
                    WHERE userid = "'.$userid.'"';

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    function create($userid, $data){
        
        try {
            $id = get_UUid($this->conn);

            $query = 'INSERT INTO userdata
                        VALUES ("'.$id.'", "'.$userid.'", "'.$data.'")';

            //prepare query statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            return true;

        } catch (Exception $e) {

            logQueryError($query, $e->getMessage());

            return false;

        }
    }

    function update($userid, $data){
        
        try {

            $query = 'UPDATE userdata
                        SET userData = "'.$data.'"
                        WHERE userid = "'.$userid.'"';

            //prepare query statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            return true;

        } catch (Exception $e) {

            logQueryError($query, $e->getMessage());

            return false;

        }
    }

    function delete($userid){
        
        try {

            $query = 'DELETE FROM userdata
                        WHERE userid = "'.$userid.'"';

            //prepare query statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            return true;

        } catch (Exception $e) {

            logQueryError($query, $e->getMessage());

            return false;

        }
    }
}