<?php
    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

$list = array("zipcode1.sql", "zipcode2.sql", "zipcode3.sql", "zipcode4.sql", "zipcode5.sql", "zipcode6.sql", "zipcode7.sql", "zipcode8.sql");

$start = microtime(true);

foreach($list as $filename) {

    $query = file_get_contents('data/zipCodeData/'.$filename);

    //prepare query statement
    $stmt = $plants->prepare($query);

    //execute query
    $stmt->execute();
}

echo "04 - ZIP CODE IMPORT COMPLETE... Task Completed in: ".microtime(true) - $start." seconds.";
print_r("\n");

?>
