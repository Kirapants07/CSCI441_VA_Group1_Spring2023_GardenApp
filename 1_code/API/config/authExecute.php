<?php 

/*
 * Author: Daniel Dietrich
 * This file is the handler for the authenication to ensure that auth.php is secure.
 * This file is passed the username and password from the login page.
 * A new instance of the userAuth class is created. 
 * The instance of userAuth is then used to validate the user account. 
 * If the credentials are invalid, the user is directed to the login page with a variable set for the error message.
 * The series is then terminated to avoid further access to the API and database.
 */

if(!defined('MyConst')) {
    die('Direct access not permitted');
}

include_once('auth.php');

$uAuth= new userAuth;

if(!$uAuth->validateUser($formUserName, $formPassword)) //If credentials are invalid...
{
    $message = "Invlaid Username/Password. Please Try again."; //Set message to inform user of invalid credentials
        header ("Location: ../../../Website/pages/login.html?sig=IC");//Display login page
        die(); //Prevents further access
}
//If credentials are valid, system continues as normal

?>