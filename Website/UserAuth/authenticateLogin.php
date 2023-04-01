<?php 
$formUserName = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_INT);
$formPassword= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
include_once ("../../API/api/user/index.php");
include_once '../../API/config/errorLogs/errorLogs.php';

$message="";
$formUserName = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_INT);
$formPassword= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
//Check if user exists
if (!users.userExists($formUserName))//If username is invalid...
{
   $message = "Invlaid Username. Please Try again."; //Set message to inform user of invalid username
   include('login.php');
}
else{ //If username is valid

    //Validate credentials
    if(!validateUser($formUserName, $formPassword))//If password is invalid 
    {
        $message = "Invlaid Username/Password. Please Try again."; //Set message to inform user of invalid credentials
        include ("login.php");//Display login page
    }
    else
    {
        // ESTABLISH SESSION VARIABLE WITH USERNAME 
        session_start();
        $_SESSION["username"] = $formUserName;
        //INCLUDE GARDEN MANAGMENT PAGE
        $message = "Login Successful!"; //MESSAGE FOR TESTING
        include ("index.html");//Display login page
    }
    }

?>
