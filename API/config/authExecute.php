<?php 

/// Execution of authentication to happen here
/// Can be used along with auth.php class file
/// Reminder that there are TWO databases in this set up
/// 1. PlantData <- read only
/// 2. PlantAdmin <- user credentials and user saved variables

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

include_once('auth.php');

$uAuth= new userAuth;

if(!$uAuth->validateUser($formUserName, $formPassword)) //If credentials are invalid.
{
    $message = "Invlaid Username/Password. Please Try again."; //Set message to inform user of invalid credentials
        header ("Location: ../../../Website/pages/login.html");//Display login page
        die(); //Prevents further access
}
//If credentials are valid, system continues as normal

?>