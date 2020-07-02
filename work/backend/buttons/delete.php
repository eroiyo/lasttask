<?php
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/user.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/cart.php' );
session_start();
$client = new user();
$cart =new cart();
$cart =$_SESSION['cart'];
//implemented in cart_page
if(!isset($_SESSION['user_id']))
{
    header('Location: /work/frontend/views/login.php');
}
else                                     
{

$client->init($_SESSION['user_id']);
$client->getCart($cart);
$client->outCart($_GET['id']);
$_SESSION['cart']=$client->cart;

header('Location: /work/frontend/views/cart_page.php');
}

?>
