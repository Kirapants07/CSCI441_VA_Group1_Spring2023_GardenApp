<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

//Script used to import all zip codes iteratively

$plantData = new Database("plantData");
$plants = $plantData->connect();

$start = microtime(true);

$query = file_get_contents('data/zoneData/plantingzone.sql');

//prepare query statement
$stmt = $plants->prepare($query);

//execute query
$stmt->execute();

echo "ZONES IMPORT COMPELTE... Task Completed in: ".microtime(true) - $start." seconds.";
print_r("\n");

?>