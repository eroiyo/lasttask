<?php
session_start();
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/cart.php' );

$message='';

if(!empty($_POST['username']) && !empty($_POST['password']))    //this is the login logic
{
    $conn= connect();
    $username =$_POST['username'];                              //here look, is the username and password
    $password =$_POST['password'];                             // obtained in the form
    $sql_u = "SELECT * FROM users WHERE username='$username'"; //here consult is the user is registered
    $res_u = mysqli_query($conn, $sql_u);
    if (mysqli_num_rows($res_u) > 0) {
        
        $row =mysqli_fetch_row($res_u);
        $message="";
        if(count($row) >0 && password_verify($password, $row[1])) //is the password is correct
        {
            $_SESSION['user_id']=$row[3];
            $cart= new cart();
            $cart->init($row[3]);
            $_SESSION['cart']=$cart;
            header('Location: /work/frontend/views/index.php');
            
        }
        else  //is the password incorrect
        {
            $message="Sorry, these crendentials do not match";
            mysqli_close($conn);
            header('Location: /work/frontend/views/login.php?message='.$message);
        }
    }
    else //is the username is not taken
    {
        $message="Thats user have no registered";
        mysqli_close($conn);
        header('Location: /work/frontend/views/login.php?message='.$message);
    }
    
}
?>