<?php
if(isset($_SESSION)){ //If there is an active session...
    session_destroy(); //Destroy the active session
}
header ("Location: ../pages/login.html?sig=SO"); //Redirect to login page

?>