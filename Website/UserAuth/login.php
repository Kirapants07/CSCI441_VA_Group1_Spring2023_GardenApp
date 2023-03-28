<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garden App</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<form name="loginForm" method="post" action="authenticateLogin.php">
    <div class="message text-center">
        <?php
        if(!isset($message)) {$message = "";} 
        if($message!="") { echo $message; } ?></div>

    

    <div class="main">
    <h1 class="text-center">Login</h1>
        <div class="row">
            <label> Username </label> <input type="text" name="username"
                class="full-width"  required>
        </div>
        <div class="row">
            <label>Password</label> <input type="password"
                name="password" class="full-width" required>
        </div>
        <div class="row">
            <input type="submit" name="submit" value="Submit"
                class="full-width ">
        </div>
    </div>
</form>

</body>
</html>