<?php 
/*
 * Author: Daniel Dietrich
 * This file recieves data from the sign up form.
 * The entered username is checked to verify that it is unique to all existing users.
 * If the username is not unique, the user is directed to the sign up page with an error message.
 * If the username is unique, a new user is created and the user is logged in automatically.
 * 
 */

 define('MyConst', TRUE);
$username = filter_input(INPUT_POST, 'signup-username', FILTER_SANITIZE_STRING); //Get username from form
$password = filter_input(INPUT_POST, 'signup-password', FILTER_SANITIZE_STRING);// Get password from form
$fname = filter_input(INPUT_POST, 'signup-firstname', FILTER_SANITIZE_STRING); //Get first name from form
$lname = filter_input(INPUT_POST, 'signup-lastname', FILTER_SANITIZE_STRING); //Get last name from form
$email = filter_input(INPUT_POST, 'signup-email', FILTER_SANITIZE_STRING); //Get email from form
$fullname = $fname." ".$lname; //Create full name variable

$data2["data"] [0]= array( //Create data item
    "userName" => $username,
    "passwordHash" => $password,
    "email" => $email,
    "firstName" => $fname,
    "lastName" => $lname,
    "fullName" => $fullname,
    "hasAccessFlag" => 1
);

include_once '../../functions/myFunctions.php';
include_once '../../model/users.php';
include_once './create.php'; //Create new user
include_once '../../config/errorLogs/errorLogs.php';


if($returnArray[0]['success'] == "true") //If account was created successfully
{
    $LoginType = "New User";
    http_response_code(302); //Allow redirects
    include_once("./authenticateLogin.php"); //Log user in
}
elseif($returnArray[0]['success'] == "false") //If account creation failed
{
    if($returnArray[0]['message'] =="User already exists. Cannot create duplicate users.") //If user already exists
    {
        header ("Location: ../../../Website/pages/sign-up.html?sig=IU"); //Display sign-up page with error
        die(); //Prevent futher access
    }
    else //If a different issue occurred
    {
        header ("Location: ../../../Website/pages/sign-up.html?sig=ER"); //Display sign-up page with generic error
        die(); //Prevent further access
    }
}
else //If a different issue occurred
{
    header ("Location: ../../../Website/pages/sign-up.html?sig=ER"); //Display sign-up page with generic error
    die(); //Prevent further access
}

?>