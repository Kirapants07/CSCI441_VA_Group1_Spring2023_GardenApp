<?php 
/*
 * Author: Daniel Dietrich
 * This file recieves the input from the login form and processes it for Authentication.
 * Once the data is processed, it is passed to index.php, which in turn passes it to executeAuth.php.
 * The file then checks to see if the session Token 'username' is set, which indicates successful authentication.
 * If the credentials were valid and authentication was successful, the userID session token is set and the user is directed to the userinfo.php
 * If the credentials were invalid, the user is directed back to the login.html page with a variable set for the error message.
 */
if($LoginType == "New User") //If signing in from account creation
{
   
    $formUserName = filter_input(INPUT_POST, 'signup-username', FILTER_SANITIZE_STRING); //Get username from form
    $formPassword = filter_input(INPUT_POST, 'signup-password', FILTER_SANITIZE_STRING);// Get password from form
}
else //If signing in from login page
{
    $formUserName = filter_input(INPUT_POST, 'login-username', FILTER_SANITIZE_STRING); //Get username from form
    $formPassword = filter_input(INPUT_POST, 'login-password', FILTER_SANITIZE_STRING);// Get password from form
}

include_once ("index.php");
include_once '../../config/errorLogs/errorLogs.php';

$message="";



//Check if user exists
if (!isset($_SESSION["username"]))//If Authentication failed
{
   $message = "Invlaid Credentials. Please Try again."; //Set message to inform user of invalid username
   include('../../../Website/pages/login.html?sig=IC');
}
else{ //If authentication was successful
    //header ("Location: ../../../Website/pages/userInfo.html");
        // ESTABLISH SESSION VARIABLE WITH USERNAME 
        $adminDB = new Database("userAdmin"); //Establish DB
        $admin = $adminDB->connect(); //Get connection
     //   $_SESSION["username"] = $formUserName; //Assisgn Username as session token
        $userOb = new users($admin); 
        $userInfo = $userOb->read($formUserName);//Get information for user account
      //  $_SESSION["userID"] = $userInfo[0]["id"]; //Assign user ID as session token
        setcookie("username", ($userInfo[0]["userName"]),  time()+3600, '/'); //Set  username cookie that will expire in 1 hour
        setcookie("email", ($userInfo[0]["email"]),  time()+3600, '/'); //Set  username cookie that will expire in 1 hou
        setcookie("userID", ($userInfo[0]["id"]),  time()+3600, '/'); //Set  user ID cookie that will expire in 1 hour
        header ("Location: ../../../Website/pages/userInfo.html");//Display user information page
    }

?>
