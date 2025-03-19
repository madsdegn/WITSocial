<!-- login -->

<!-- Mads Degn -->
<!-- 13/03-25 -->

<!DOCTYPE html>
<html>
    <head>
    <style>

input[type='text'] { 
    font-size: 20px;
    font-family: Arial, sans-serif;
    text-align: center;
}

input[type='password'] { 
    font-size: 20px;
    font-family: Arial, sans-serif;
    text-align: center;
}

input[type='submit'] { 
    font-size: 20px;
    font-family: Arial, sans-serif;
    text-align: center;
    margin: 0;
    position: absolute;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    
}

#title {
    font-family: Arial, sans-serif;
    text-align: center;
    background-color: white;
    width: 300px;
    border: 7px solid black;
    padding: 2px;
    margin: auto;
    font-size: 45px;
}

#login {
    font-family: Arial, sans-serif;
    text-align: left;
    background-color: white;
    width: 400px;
    border: 7px solid black;
    padding: 50px;
    margin: auto;
    font-size: 20px;
}

#message {
    font-family: Arial, sans-serif;
    text-align: center;
    font-size: 20px;
}

</style>
    </head>
    <body>
<br>
        <div id="title">
    <b>WITS</b>ocial
</div>

<br><br>

<?php
require_once '/var/www/wits.ruc.dk/db.php';

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $uid = $_POST['uid'] ?? '';
    $password = $_POST['password'] ?? '';

    if(login($uid, $password)) {
        header("Location: secrets.php");
        exit();
    } else {
        $message = "<div id='message' style='color: red;'><br><br>Credentials Incorrect";
    }
}
?>

<div id="login">
    <form method="POST" action="">
        <label for="uid">User ID</label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" id="uid" name="uid" value="Example">
        <br><br>
        <label for="password">Password</label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="password" id="password" name="password" value="••••••••••">
        <br><br><br>
        <input type="submit" value="Log In">
        
</form>

<div id="message"><?php echo $message; ?></div>

</div>
    </body>
</html>