<?php

    if(!defined('MyConst')) {
        die('Direct access not permitted');
    }

    function logQueryError($query, $pdoErr)
    {
        date_default_timezone_set('America/New_York'); // on deployment this needs to change to UTC-0

        //write this later
        //to queryErrors.txt

        $myfile = fopen("../../config/errorLogs/queryErrors.log", "a");

        $message = "--HISTORY LOG ERR--  DATE: ".date('Y-m-d H:i:s')."  ERROR: ".$pdoErr."\n\t\tQUERY: ".$query."\n";

        fwrite($myfile, $message);

        fclose($myfile);
    }

    function logCodeItem($string)
    {
        date_default_timezone_set('America/New_York'); // on deployment this needs to change to UTC-0
        
        //logs a simple output to the log for testing purposes

        $myfile = fopen("../../config/errorLogs/codeErrors.log", "a");

        $message = "--CODE TRACKING ITEM--  DATE: ".date('Y-m-d H:i:s')."  OUTPUT: ".$string."\n";

        fwrite($myfile, $message);

        fclose($myfile);
        
    }

?>