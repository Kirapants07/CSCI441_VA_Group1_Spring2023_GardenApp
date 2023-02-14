<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

class plantgrowingrelationship{

    //database connection and table name
    private $conn;
    private $tableName = "plantgrowingrelationship";

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
        if(array_key_exists("id", $_GET))
        {
            $query = 'SELECT plantgrowingrelationship.id, 
                                plantgrowingrelationship.plantIdOne,
                                plantONE.name AS plantNameOne,
                                plantgrowingrelationship.plantIdTwo, 
                                plantTwo.name AS plantNameTwo,
                                plantgrowingrelationship.relationship
                        FROM plantgrowingrelationship
                            JOIN plant AS plantONE ON plantIdOne = plantONE.id
                            JOIN plant AS plantTWO ON plantIdTwo = plantTWO.id
                        WHERE plantgrowingrelationship.id = "'.$_GET['id'].'"';
        }
        else if(array_key_exists("name", $_GET))
        {
            $query = 'SELECT plantgrowingrelationship.id, 
                                plantgrowingrelationship.plantIdOne,
                                plantONE.name AS plantNameOne,
                                plantgrowingrelationship.plantIdTwo, 
                                plantTwo.name AS plantNameTwo,
                                plantgrowingrelationship.relationship
                        FROM plantgrowingrelationship
                            JOIN plant AS plantONE ON plantIdOne = plantONE.id
                            JOIN plant AS plantTWO ON plantIdTwo = plantTWO.id
                        WHERE plantONE.name = "'.$_GET['name'].'" OR plantTwo.name = "'.$_GET['name'].'"';
        }
        else if(array_key_exists("plant1Name", $_GET) && array_key_exists("plant2Name", $_GET))
        {
            $query = 'SELECT plantgrowingrelationship.id, 
                                plantgrowingrelationship.plantIdOne,
                                plantONE.name AS plantNameOne,
                                plantgrowingrelationship.plantIdTwo, 
                                plantTwo.name AS plantNameTwo,
                                plantgrowingrelationship.relationship
                        FROM plantgrowingrelationship
                            JOIN plant AS plantONE ON plantIdOne = plantONE.id
                            JOIN plant AS plantTWO ON plantIdTwo = plantTWO.id
                        WHERE (plantONE.name = "'.$_GET['plant1Name'].'" AND plantTwo.name = "'.$_GET['plant2Name'].'")
                                OR
                                (plantONE.name = "'.$_GET['plant2Name'].'" AND plantTwo.name = "'.$_GET['plant1Name'].'")';
        }
        //select all query 
        else{
            $query = 'SELECT plantgrowingrelationship.id, 
                                plantgrowingrelationship.plantIdOne,
                                plantONE.name AS plantNameOne,
                                plantgrowingrelationship.plantIdTwo, 
                                plantTwo.name AS plantNameTwo,
                                plantgrowingrelationship.relationship
                        FROM plantgrowingrelationship
                            JOIN plant AS plantONE ON plantIdOne = plantONE.id
                            JOIN plant AS plantTWO ON plantIdTwo = plantTWO.id';                                  
        }

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
        $num = $stmt->rowCount();

        //check if more than 0 record found
        if($num>0){

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        else {
            return null;
        }
    }
}

?>