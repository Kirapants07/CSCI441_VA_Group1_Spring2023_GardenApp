<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

$start = microtime(true);

$query = file_get_contents('data/plants/plantgrowingrelationship.sql');

//prepare query statement
$stmt = $plants->prepare($query);

//execute query
$stmt->execute();

echo "PLANT RELATIONSHIP IMPORT COMPELTE... Task Completed in: ".microtime(true) - $start." seconds.";
print_r("\n");

?>