<?php 
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/user.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/cart.php' );
session_start();
$client = new user();
$cart =new cart();
//implemented in index
if(!isset($_SESSION['user_id']))
{
    header('Location: /work/frontend/views/index.php');
}
else                                    
{
    $cart =$_SESSION['cart'];
    $conn=connect();
    $client->init($_SESSION['user_id']);
    $client->getCart($cart);
    $client->money=$client->money+100;
    $sql_u ="UPDATE users SET money=$client->money WHERE user_id=$client->user_id";
    $res_u=mysqli_query($conn, $sql_u);
    mysqli_close($conn);
    
    header('Location: /work/frontend/views/index.php');
}