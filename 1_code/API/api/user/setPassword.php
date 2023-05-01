<?php
/*
 * Author: Daniel Dietrich
 * This file recieves the input from the set password form to change password.
 * The file recieves the new password and an encoded user ID from the form.
 * The file first verifies that the user exists based on the user ID, then
 * updates the password. The user is then directed to the sign in page.
 */
 define('MyConst', TRUE);
 $eid = filter_input(INPUT_POST, 'reset-eid', FILTER_SANITIZE_STRING); //Get encoded id from form
 $password = filter_input(INPUT_POST, 'reset-password', FILTER_SANITIZE_STRING); //Get password from form
 include_once('../../config/database.php');

 $id = base64_decode($eid); //Decode user ID
 //Check if user id is valid
 $adminDB = new Database("userAdmin");
$admin = $adminDB->connect();
$query = 'SELECT userName, id
FROM users
WHERE id = "'.$id.'"';

$statement = $adminDB->conn->prepare($query);

    //execute query
    $statement->execute();

if($statement->rowCount() > 0)
    $user_info = $statement->fetchAll(\PDO::FETCH_ASSOC);
else
    $user_info = null;

    if($user_info == null){ //If the is no user for the specified user id
        header ("Location: ../../../Website/pages/setPassword.html?sig=IU"); //Display password reset page with error
        die(); //Prevent futher access
    }
    else{ //IF the is a user for the specified ID
        include_once '../../model/users.php';

        $uAuth= new userAuth;
        $hashedPass = $uAuth->hashPass($password); //Hash the entered password
        //Update the user password
        $query = 'Update users
        set passwordHash = "'.$hashedPass.'"
        WHERE id = "'.$id.'"';

        $statement = $adminDB->conn->prepare($query);

         //execute query
         $statement->execute();
        //Navigate to login page
         header ("Location: ../../../Website/pages/login.html?sig=PR");//Display user information page
    }
?>