<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

$start = microtime(true);

$query = file_get_contents('data/users/testusers.sql');

//prepare query statement
$stmt = $adm->prepare($query);

//execute query
$stmt->execute();

$query = file_get_contents('data/users/testuserdata.sql');

//prepare query statement
$stmt = $adm->prepare($query);

//execute query
$stmt->execute();

echo "09 - USERS IMPORT COMPELTE... Task Completed in: ".microtime(true) - $start." seconds.";
print_r("\n");

?>