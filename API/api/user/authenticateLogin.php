<?php 
$formUserName = filter_input(INPUT_POST, 'signup-email', FILTER_SANITIZE_STRING);
$formPassword= filter_input(INPUT_POST, 'signup-password', FILTER_SANITIZE_STRING);

include_once ("index.php");
include_once '../../config/errorLogs/errorLogs.php';

$message="";



//Check if user exists
if (!isset($_SESSION["username"]))//If Authentication failed
{
   $message = "Invlaid Credentials. Please Try again."; //Set message to inform user of invalid username
   include('../../../Website/pages/login.html');
}
else{ //If authentication was successful

        // ESTABLISH SESSION VARIABLE WITH USERNAME 
        $adminDB = new Database("userAdmin"); //Establish DB
        $admin = $adminDB->connect(); //Get connection
        $_SESSION["username"] = $formUserName; //Assisgn Username as session token
        $userOb = new users($admin); 
        $userInfo = $userOb->read($_SESSION["username"]);//Get information for user account
        $_SESSION["userID"] = $userInfo["id"]; //Assign user ID as session token
        $message = "Login Successful!"; //Login Confirmation message
        header ("Location: ../../../Website/pages/userinfo.html");//Display user information page
    }

?>
