<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

//Script used to import all zip codes iteratively

$plantData = new Database("plantData");
$plants = $plantData->connect();

$count = 0;

$start = microtime(true);

$query = "INSERT plantingzone  
            (id, number)  
            VALUES  
            (uuid(), '3'),
            (uuid(), '4'),
            (uuid(), '5'),
            (uuid(), '6'),
            (uuid(), '7'),
            (uuid(), '8'),
            (uuid(), '9'),
            (uuid(), '10'),
            (uuid(), '11');";

//prepare query statement
$stmt = $plants->prepare($query);

//execute query
$stmt->execute();

echo "ZONES IMPORT COMPELTE... Task Completed in: ".microtime(true) - $start." seconds.";
print_r("\n");

?>