<?php
 define('MyConst', TRUE);
 $eid = filter_input(INPUT_POST, 'reset-eid', FILTER_SANITIZE_STRING); //Get username from form
 $password = filter_input(INPUT_POST, 'reset-password', FILTER_SANITIZE_STRING); //Get password from form
 include_once('../../config/database.php');

 $id = base64_decode($eid);
 //Check if email is valid
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

    if($user_info == null){
        header ("Location: ../../../Website/pages/setPassword.html?sig=IU"); //Display password reset page with error
        die(); //Prevent futher access
    }
    else{
        include_once '../../model/users.php';

        $uAuth= new userAuth;
        $hashedPass = $uAuth->hashPass($password);
        $query = 'Update users
        set passwordHash = "'.$hashedPass.'"
        WHERE id = "'.$id.'"';

        $statement = $adminDB->conn->prepare($query);

         //execute query
         $statement->execute();

         header ("Location: ../../../Website/pages/login.html?sig=PR");//Display user information page
    }
?>