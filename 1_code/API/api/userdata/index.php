<?php
    //This serves as the user controller

    define('MyConst', TRUE);

    //AUTH EXECUTION NEEDS TO GO HERE IF THE APP DOES NOT PROVIDE CREDENTIALS THEY GO NO FURTHER.
    //END AUTH

    include_once '../../model/users.php';
    include_once '../../model/userData.php';
    include_once '../../config/indexHeaderCRUD.php';

?>