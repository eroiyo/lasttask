<?php 
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/user.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/cart.php' );
session_start();                                                          
$client = new user();
$cart =new cart();
//implemented in the product_page
if(!isset($_SESSION['user_id']))
{
    header('Location: /work/frontend/views/login.php');
}
else                                      
{
    $cart =$_SESSION['cart']; 
    $client->init($_SESSION['user_id']);
    $client->getCart($cart);
    $client->pushCart($_GET['id'],$_POST['quantity']);                       
    $_SESSION['cart']=$client->cart;
}
header('Location: /work/frontend/views/index.php');


?>