<?php

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

class plant{

    //database connection and table name
    private $conn;
    private $tableName = "plant";

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
        if($where != "" && str_contains($where, "type"))
        {
            $query = 'SELECT * 
                        FROM '.$this->tableName.' 
                        WHERE type = "'.$_GET['type'].'"
                        ORDER BY name asc';
        }
        else if($where != "")
        {
            $query = 'SELECT * 
                        FROM '.$this->tableName.' 
                        WHERE '.$where.'
                        ORDER BY name asc';
        }
        //select all query 
        else{
            $query = 'SELECT *  
                        FROM '.$this->tableName.' 
                        ORDER BY name asc';                                  
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
            if(!empty($_GET) && $where != "" && !str_contains($where, "type")){
                //arm array
                $output_arr = array();

                //retrive arm table conents
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    
                    //extract row
                    extract($row);
                    $item = array(
                        "id" => $id,
                        "name" => $name,
                        "pluralName" => $pluralName,
                        "type" => $type,
                        "spacing" => $spacing,
                        "germinationInformation" => $germinationInformation,
                        "harvestInformation" => $harvestInformation,
                        "plantinginstructions" => $this->instructionsAssoc($id),
                        "growingrelationships" => $this->growingrelationshipAssoc($id)
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

    private function growingrelationshipAssoc($id)
    {
        $query = '';
       
        $query = 'SELECT plantgrowingrelationship.id, 
                         plantgrowingrelationship.plantIdOne,
                         plantONE.name AS plantNameOne,
                         plantgrowingrelationship.plantIdTwo, 
                         plantTwo.name AS plantNameTwo,
                         plantgrowingrelationship.relationship
                    FROM plantgrowingrelationship
                        JOIN plant AS plantONE ON plantIdOne = plantONE.id
                        JOIN plant AS plantTWO ON plantIdTwo = plantTWO.id
                    WHERE plantIdOne = "'.$id.'" OR plantIdTwo = "'.$id.'"';

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
    private function instructionsAssoc($id)
    {
        if(array_key_exists('zoneid', $_GET) || array_key_exists('zonenum', $_GET) || array_key_exists('zonesub', $_GET)) {
            $query = $this->instructionsQuery($id);
        }
        else {
            $query = 'SELECT * 
                    FROM plantinginstructions 
                    WHERE plantid = "'.$id.'"
                    ORDER BY zoneid, plantingZoneSub, season';
        }

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

    private function instructionsQuery($id)
    {
        //Planting instructions allows the user to specify additional URL params to narrow down return results
        //These are: zoneid, zonenum, zonesub
        //This method dynamic writes that query based on the informatin provided

        (array_key_exists('zoneid', $_GET)) ? $zoneid = $_GET['zoneid'] : $zoneid = null;
        (array_key_exists('zonenum', $_GET)) ? $zonenum = $_GET['zonenum'] : $zonenum = null;
        (array_key_exists('zonesub', $_GET)) ? $zonesub = $_GET['zonesub'] : $zonesub = null;

        $where_args = array();

        if($zoneid === null && $zonenum != null) {
            //get the id
            $zoneid = $this->zoneidlookup($zonenum);
        }

        //combined where clauses into string
        if($zoneid != null) {
            $where_args[] = 'zoneId="'.$zoneid[0]['id'].'"';
        }

        if($zonesub != null) {
            $where_args[] = 'plantingZoneSub="'.$zonesub.'"';
        }

        //write the query

        return 'SELECT * 
                FROM plantinginstructions 
                WHERE '.implode(' AND ', $where_args).'
               ORDER BY zoneid, plantingZoneSub, season';
    }

    private function zoneidlookup($zonenum) {
        $query = '';
       
        $query = 'SELECT id 
                    FROM plantingzone 
                    WHERE number = "'.$zonenum.'"';

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