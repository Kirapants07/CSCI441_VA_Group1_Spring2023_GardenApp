<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

class plantinginstructions{

    //database connection and table name
    private $conn;
    private $tableName = "plantinginstructions";

    //object properties

    //constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function getConn(){
        return $this->conn;
    }

    //read quotes
    function read(){
        
        $query = '';
        
        //only id provided
        if(array_key_exists("id", $_GET))
        {
            $query = 'SELECT plantinginstructions.id,
                                plantinginstructions.plantId,
                                plant.name AS plantName,
                                plantinginstructions.zoneId,
                                plantingZone.number AS zoneNumber,
                                plantinginstructions.plantingZoneSub,
                                plantinginstructions.season,
                                plantinginstructions.plantingType,
                                plantinginstructions.startDate,
                                plantinginstructions.endDate
                        FROM plantinginstructions
                            JOIN plant ON plant.id = plantinginstructions.plantId
                            JOIN plantingzone ON plantingzone.id = plantinginstructions.zoneId
                        WHERE plantinginstructions.id = "'.$_GET['id'].'"
                        ORDER BY plant.name, plantingZone.number, plantingZoneSub, season';
        }
        else if(array_key_exists("zoneId", $_GET))
        {
            $query = 'SELECT plantinginstructions.id,
                                plantinginstructions.plantId,
                                plant.name AS plantName,
                                plantinginstructions.zoneId,
                                plantingZone.number AS zoneNumber,
                                plantinginstructions.plantingZoneSub,
                                plantinginstructions.season,
                                plantinginstructions.plantingType,
                                plantinginstructions.startDate,
                                plantinginstructions.endDate
                        FROM plantinginstructions
                            JOIN plant ON plant.id = plantinginstructions.plantId
                            JOIN plantingzone ON plantingzone.id = plantinginstructions.zoneId
                        WHERE plantinginstructions.zoneId = "'.$_GET['zoneId'].'"
                        ORDER BY plant.name, plantingZone.number, plantingZoneSub, season';
        }
        else if(array_key_exists("zoneNum", $_GET))
        {
            $query = 'SELECT plantinginstructions.id,
                                plantinginstructions.plantId,
                                plant.name AS plantName,
                                plantinginstructions.zoneId,
                                plantingZone.number AS zoneNumber,
                                plantinginstructions.plantingZoneSub,
                                plantinginstructions.season,
                                plantinginstructions.plantingType,
                                plantinginstructions.startDate,
                                plantinginstructions.endDate
                        FROM plantinginstructions
                            JOIN plant ON plant.id = plantinginstructions.plantId
                            JOIN plantingzone ON plantingzone.id = plantinginstructions.zoneId
                        WHERE plantingZone.number = "'.$_GET['zoneNum'].'"
                        ORDER BY plant.name, plantingZone.number, plantingZoneSub, season';
        }
        //select all query 
        else{
            $query = 'SELECT plantinginstructions.id,
                             plantinginstructions.plantId,
                             plant.name AS plantName,
                             plantinginstructions.zoneId,
                             plantingZone.number AS zoneNumber,
                             plantinginstructions.plantingZoneSub,
                             plantinginstructions.season,
                             plantinginstructions.plantingType,
                             plantinginstructions.startDate,
                             plantinginstructions.endDate
                        FROM plantinginstructions
                            JOIN plant ON plant.id = plantinginstructions.plantId
                            JOIN plantingzone ON plantingzone.id = plantinginstructions.zoneId
                        ORDER BY plant.name, plantingZone.number, plantingZoneSub, season';                                  
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