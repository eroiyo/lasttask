<?php 
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/user.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/cart.php' );
session_start();
$client = new user();
$cart =new cart();
if(!isset($_SESSION['user_id']) && !isset($_POST['quantity']))
{
    header('Location: /work/frontend/views/index.php');
}
//this function is needed to change the quantity of a group of products is used in the cart page
else
{
    $cart =$_SESSION['cart'];
    $client->init($_SESSION['user_id']);
    $client->getCart($cart);
    $client->quantityCart($_GET['id'],$_POST['quantity']);  
    $_SESSION['cart']=$client->cart;
}
header('Location: /work/frontend/views/cart_page.php');


?>