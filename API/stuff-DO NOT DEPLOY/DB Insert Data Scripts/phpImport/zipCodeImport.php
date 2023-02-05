<?php

//uncomment the below line to use zip code import on initial data base creation
//define('MyConst', TRUE);

//Script used to import all zip codes iteratively

require_once("../../../config/database.php");

$plantData = new Database("plantData");
$plants = $plantData->connect();

$lines = file('zipCodes.txt');

$count = 0;

$start = microtime(true);

foreach($lines as $line) {

    $count += 1;

    $query = 'INSERT INTO zipcode  
                (id, zipCode, plantingZoneId, plantingZoneSub, tempRange)  
                VALUES '.$line.'';

    //prepare query statement
    $stmt = $plants->prepare($query);

    //execute query
    $stmt->execute();

    echo "Task # ".$count. "complete.";
}

echo "Task Completed in: ".microtime(true) - $start." seconds";

?>
