<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

class plantingzone{

    //database connection and table name
    private $conn;
    private $tableName = "plantingzone";

    //object properties

    //constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function getConn(){
        return $this->conn;
    }

    //read quotes
    function read($where){
        
        $query = '';
        
        //only id provided
        if($where != "")
        {
            $query = 'SELECT * 
                        FROM '.$this->tableName.' 
                        WHERE '.$where.'
                        ORDER BY number asc';
        }
        //select all query 
        else{
            $query = 'SELECT *  
                        FROM '.$this->tableName.' 
                        ORDER BY number asc';                                  
        }

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
        $num = $stmt->rowCount();

        //check if more than 0 record found
        if($num>0){
            //if $id is specified we also need to return a list of studies associated with it
            //other wise, just return the entire list of arms
            if(!empty($_GET) && $where != ""){
                //arm array
                $output_arr = array();

                //retrive arm table conents
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    
                    //extract row
                    extract($row);
                    $item = array(
                        "id" => $id,
                        "number" => $number,
                        "zipcodes" => $this->zipCodeAssoc($id)
                    );

                    array_push($output_arr, $item);
                }

                return $output_arr;
            }
            else{

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        else {
            return null;
        }
    }

    private function zipCodeAssoc($id)
    {
        $query = '';
       
        $query = 'SELECT * 
                    FROM zipcode 
                    WHERE plantingZoneid = "'.$id.'"';

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        else{
            return null;
        }
    }
}

?>