<?php
    //This serves as the zipcode controller

    define('MyConst', TRUE);

    //AUTH NEEDS TO GO HERE IF THE APP DOES NOT PROVIDE CREDENTIALS THEY GO NO FURTHER.
    class userAuth{
    
        private $pepper = "THIS IS THE USER AUTH PEPPER. ";
    
        function hashPass($password)
        {
            $peppered_Pass = hash_hmac("sha256", $password, $this->pepper);
            return $peppered_pass;
        }
    
        function validateUser($enteredUsername, $enteredPass)
        {
                //Get user data
                $adminDB = new Database("userAdmin");
                $admin = $adminDB->connect();
                $query = 'SELECT userName, passwordHash
                FROM users
                WHERE userName = "'.$enteredUsername.'"';
    
                $statement = $this->conn->prepare($query);
    
                 //execute query
                 $statement->execute();
    
                if($statement->rowCount() > 0)
                    $user_info = $statement->fetchAll(\PDO::FETCH_ASSOC);
                else
                    $user_info = null;
                 
                //Hash Password
                $hashed_entered_pass = hashPass($enteredPass);
    
                if($user_info != null){ 
                    //Compare Hashed password to passwordHash
                    if($user_info[0]['passwordHash'] == crypt($hashed_entered_pass, $user_info[0]['passwordHash'])) { //If the passwords are the same
                        return true;
                    }
                    else{ //If the passwords are not equal
                        return false;
                    }
                }
                else{ //If user_data == null, return false
                    return false;
                }
        
        }
    }
    //END AUTH

    include_once '../../model/users.php';
    include_once '../../model/userData.php';
    include_once '../../config/indexHeaderCRUD.php';

?>