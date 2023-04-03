<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

//Script used to import all zip codes iteratively

$create = new Database();
$newDB = $create->createDatabase();


$arrayQueries = array("DROP DATABASE plantData;",
                 "CREATE DATABASE plantData;",
                 "DROP DATABASE useradmin",
                 "CREATE DATABASE useradmin");
$start = microtime(true);

foreach($arrayQueries as $query)
{

    //prepare query statement
    $stmt = $newDB->prepare($query);
    
    //execute query
    $stmt->execute();
}

echo "01 - DATABASES DUMPED AND RECREATED... Task Completed in: ".microtime(true) - $start." seconds.";
print_r("\n");


?>