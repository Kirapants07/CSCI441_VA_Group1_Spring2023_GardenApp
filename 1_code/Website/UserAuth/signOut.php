<?php
if(isset($_SESSION)){ //If there is an active session...
    session_destroy(); //Destroy the active session
}
//Destroy all cookies
if (isset($_COOKIE["username"])){
    unset($_COOKIE["username"]);
    setcookie('username', null, -1, '/');
}

if (isset($_COOKIE["userID"])){
    unset($_COOKIE["userID"]);
    setcookie('userID', null, -1, '/');
}

if (isset($_COOKIE["PHPSESSID"])){
    unset($_COOKIE["PHPSESSID"]);
    setcookie('PHPSESSID', null, -1, '/');
}

header ("Location: ../pages/login.html?sig=SO"); //Redirect to login page

?>