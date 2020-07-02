<?php
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/user.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/cart.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/star.php' );
session_start();
$client = new user();
$cart =new cart();
if(!isset($_SESSION['user_id']))
//implemented in index
{
    header('Location: /work/frontend/views/index.php');
}
else
{                                            //this print the javascript needed to print for the star rating system used in index
    $star =new Star();
    $star->set($_GET['product_id']);
    $value=$_GET['value'];
    $product_id=$_GET['product_id'];
    if($value>5)
    {
    	$value=5;
    }
    if($value<1)
    {
    	$value=1;
    }
    $star->save($_SESSION['user_id'],$value);
    header('Location: /work/frontend/views/index.php');
}