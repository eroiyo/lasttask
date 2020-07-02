<?php 
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/user.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/cart.php' );
session_start();
$client = new user();
$cart =new cart();
if(!isset($_SESSION['user_id']))
{
    header('Location: /work/frontend/views/login.php');
}
else
{
    $cart =$_SESSION['cart'];
    $client->init($_SESSION['user_id']);
    $client->getCart($cart);
    $client->modifyCart($_GET['id'],$_GET['change']);
    $_SESSION['cart']=$client->cart;
}
header('Location: /work/frontend/views/cart_page.php');


?>