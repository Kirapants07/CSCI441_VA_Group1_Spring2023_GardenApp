<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

$query = file_get_contents('../../DB Creation empty/userAdmin.sql');

$start = microtime(true);

//prepare query statement
$stmt = $adm->prepare($query);

//execute query
$stmt->execute();

echo "08 - USERADMIN TABLE RECREATION COMPLETE... Task Completed in: ".microtime(true) - $start." seconds.";
print_r("\n");

?>
