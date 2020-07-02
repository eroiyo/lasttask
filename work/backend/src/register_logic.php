<?php
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );

$message='';

if(!empty($_POST['username']) && !empty($_POST['password']))
{
    $conn= connect();
    $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
    $username =$_POST['username'];                                  //obtain an hash the form information
    $sql_u = "SELECT * FROM users WHERE username='$username'";
    $res_u = mysqli_query($conn, $sql_u);
    if (mysqli_num_rows($res_u) > 0) //verify is the user if taken 
    {
        mysqli_close($conn);
        $message = "Sorry... username already taken";
        header('Location: /work/frontend/views/register.php?message='.$message);
    }
    else //in contrary case its register
    {
        $query= "INSERT INTO users (username, money, password)
      	    	  VALUES ('$username','100','$password')";
        $results = mysqli_query($conn, $query);
        mysqli_close($conn);
        $message="You have been registered";
        header('Location: /work/frontend/views/login.php?message='.$message);
    }
}
?>