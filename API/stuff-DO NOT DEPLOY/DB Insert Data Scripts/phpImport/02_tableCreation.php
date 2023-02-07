<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

$query = file_get_contents('../../DB Creation empty/plantData.sql');

$start = microtime(true);

//prepare query statement
$stmt = $plants->prepare($query);

//execute query
$stmt->execute();

echo "TABLE RECREATION COMPLETE... Task Completed in: ".microtime(true) - $start." seconds.";
print_r("\n");

?>
