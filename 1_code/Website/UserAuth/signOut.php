<?php
if(isset($_SESSION)){ //If there is an active session...
    session_destroy(); //Destroy the active session
}

if (isset($_COOKIE["username"])){
    unset($_COOKIE["username"]);
}

if (isset($_COOKIE["userID"])){
    unset($_COOKIE["userID"]);
}

header ("Location: ../pages/login.html?sig=SO"); //Redirect to login page

?>