<?php

/*
*Author: Daniel Dietrich
* This file generates a password reset email using data collected from the 
* resetPassword.html form.
* The email utilizes the PHPMailer open source library to allow the application to
* be more portable accross platforms and systems.
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../functions/PHPMailer/src/Exception.php';
require '../../functions/PHPMailer/src/PHPMailer.php';
require '../../functions/PHPMailer/src/SMTP.php';

 define('MyConst', TRUE);
 $email = filter_input(INPUT_POST, 'reset-email', FILTER_SANITIZE_STRING); //Get email from form
 include_once('../../config/database.php');

 //Check if email is valid
 $adminDB = new Database("userAdmin");
$admin = $adminDB->connect();
$query = 'SELECT userName, id
FROM users
WHERE email = "'.$email.'"';

$statement = $adminDB->conn->prepare($query);

    //execute query
    $statement->execute();

if($statement->rowCount() > 0)
    $user_info = $statement->fetchAll(\PDO::FETCH_ASSOC);
else
    $user_info = null;

if($user_info == null) //If no account is found for the given email
{
    header ("Location: ../../../Website/pages/resetPassword.html?sig=IE"); //Display password reset page with error
    die(); //Prevent futher access
}
else{
    $encodedUserID = base64_encode($user_info[0]['id']);
    $username = $user_info[0]['userName'];
    
    //Create email
    $mail_body = '
    Hello '.$username.'
    
    Please click the link below to reset your password:
    http://localhost/cSCI441_VA_Group1_Spring2023_GardenApp/1_code/Website/pages/setPassword.html?eid='.$encodedUserID.'';
    $Subject = "Garden Planner: Password Reset";

    $mail = new PHPMailer(true);

    //Send mail using gmail
    
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 465; // set the SMTP port for the GMAIL server
        $mail->Username = "noreply.gardenapp.675@gmail.com"; // GMAIL username
        $mail->Password = "rnmbblhpnicxpeui"; // GMAIL password
    
    
    //Typical mail data
    $mail->AddAddress($email, $username);
    
    $mail->Subject = $Subject;
    $mail->Body = $mail_body;


    //Send email and display result
    if(!$mail->Send())
    {
        echo "Email did not send.";
    }
    else{
        header ("Location: ../../../Website/pages/resetPassword.html?sig=ES"); //Display password reset page with message
        die(); //Prevent futher access
    }

}
?>