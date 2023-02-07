<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

//Script used to import all zip codes iteratively

$create = new Database();
$newDB = $create->createDatabase();

$query1 = "DROP DATABASE plantData;";
$query2 = "CREATE DATABASE plantData;";

$start = microtime(true);

//prepare query statement
$stmt = $newDB->prepare($query1);

//execute query
$stmt->execute();

//prepare query statement
$stmt = $newDB->prepare($query2);

//execute query
$stmt->execute();

echo "01 - DATABASE DUMPED AND RECREATED... Task Completed in: ".microtime(true) - $start." seconds.";
print_r("\n");


?>