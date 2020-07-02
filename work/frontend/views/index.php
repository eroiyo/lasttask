<?php
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/user.php');
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/products.php'); 
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/star.php'); 
session_start();
$client = new user();
$cart= new cart();
if(isset($_SESSION['user_id']))
{
    $client->init($_SESSION['user_id']);
    $cart->init($_SESSION['user_id']);
    $client->getCart($cart);
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Materialiaze icon-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Materialiaze CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--self style-->
    <link rel="stylesheet" href="../public/style.css">
    <!--Stars Css-->
    <link rel="stylesheet" href="../public/starrr.css">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
    <title>Online Store</title>
</head>                     
<body>
    <nav class="lime accent-1">
        <div class="nav-wrapper">
        <a href="../../backend/buttons/extramoney.php" class="brand-logo orange-text right"><?php $client->ifconnprintorelse($client->money."$","0$")?></a>
                      <?php  
                      $client->ifconnprintorelse
                      ('<a href= "../../backend/src/logout.php" class="brand-logo orange-text center">logout</a>',
                          //or
                       '<a href= "login.php" class="brand-logo orange-text center">login</a>')
                      ?>
            <div class="container">
                <a href="index.php" class="brand-logo blue-text left">Last Task</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
 
        <?php $client->ifconnprint('<li><a href="" class=" blue-text">Welcome '.$client->username.'</a></li>')?>
 
        <li><a href="cart_page.php"><i class="material-icons blue-text">add_shopping_cart</i></a></li>
 
        <li><a class="brand-logo orange-text"><?php $client->ifconnprintorelse($cart->pquantity,"0"); ?></a></li>
 
      </ul> 
                    
                </ul>
            </div>
        </div>
    </nav>

    <!--Cards model-->
   <?php $allproducts = new Product();
    $allproducts->showAll();  //this print all the products, for the buyer?>
    
        

    <!--Script Materialiaze-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!--Jquery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!--Jquery Stars-->
    <script src="../public/starrr.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });
        <?php $starsystem = new Star();
        if(isset($_SESSION['user_id']))
        {
            $starsystem->editableindexAll($_SESSION['user_id']);
        }
        else
        {
            $starsystem->editableindexAll(null);
        }  //this print all the rating star sistem, ?>
        
    </script>
</body>
</html>