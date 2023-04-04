<?php
/*
 * Author: Daniel Dietrich
 * This file is to test the userAuth class located in the auth.php file.
 * To run these tests, access this page using a web browser. 
 * All tests will be run automatically and results will be displayed in browser.
 */

define('MyConst', TRUE);

//Test for userAuth class
include_once('../1_code/API/config/auth.php');  //Include Auth

//Test userAuth->hashPass()
echo nl2br ("Testing userAuth->hashPass()\n");
$testAuth = new userAuth; //Declare new instance of UserAuth
$testPass = "Password12321"; //Create test password
echo nl2br (" - Password for Test Hash = Password12321\n");
$hashed = $testAuth->hashPass($testPass); //Hash test password
echo nl2br (" - Hashed Password = $hashed\n\n"); //Display result

$testUser = "invalidUser"; //Delcare test user name
echo nl2br ("Testing userAuth->validateUser()\n");
echo nl2br (" - Invalid User Test:\n");
if(!$testAuth->validateUser($testUser, $testPass)) //Test invalid credentials. If invalid credentials are blocked...
    echo nl2br (" -- Invalid Credentials caught Successfully.\n"); //Display pass message
else //If invalid credentials are accepted...
    echo nl2br (" -- Failed to catch invalid credentials.\n"); //Display fail message

echo nl2br (" - Valid User Test:\n");
if($testAuth->validateUser("testerUser1", "TestPassword121212")) //Test valid credentials. If valid credentials are accepted...
    echo nl2br (" -- Valid Credentials approved Successfully.\n"); //Display pass message
else //If valid credentials are blocked...
    echo nl2br (" -- Failed to approve valid credentials.\n"); //Display fail message

echo nl2br ("\nEnd of Tests.\n"); //Display ending message

?>