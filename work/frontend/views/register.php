<?php 
session_start();
if(isset($_SESSION['user_id']))
{
    header('Location: /work/frontend/views/index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/login_and_register_style.css">
    <title>Register</title>
</head>
<body>
    <form action='../../backend/src/register_logic.php'  method="post" id="Form">
        <h1 id="Title">Register</h1>
        <?php
        if(isset($_GET['message']))  //simple register form
        {
        echo $_GET['message'];
        }
        ?> 
        <input type="username" name="username" placeholder="Username" required>
        <input type="password" name="password" id="password" placeholder="Password">
        <input type="submit" value="Register">
        <a href="login.php">Login</a>
    </form>
</body>
</html>