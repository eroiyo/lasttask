<?php 
session_start();
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/user.php');
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/products.php');
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/cart.php');
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/star.php');

$product= new Product();
$product->set($_GET['id']);
$client = new user();
$cart= new cart();
if(isset($_SESSION['user_id']))
{
    $client->init($_SESSION['user_id']);
    $cart->init($_SESSION['user_id']);
    $client->getCart($cart);                               //initializing user
}
else
{
    header('Location: /work/frontend/views/index.php');  // if you no are connected you cant stay here
}
?>
<!DOCTYPE html>
<!-- saved from url=(0076)file:///C:/Users/DISCO%20DE%20DANIEL/Desktop/work/frontend/views/apple2.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/materialize.min.css">
    <link rel="stylesheet" href="../public/style2.css">
    <!--Stars Css-->
    <link rel="stylesheet" href="../public/starrr.css"/>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
    <title><?php echo "Last Task ".$product->name;?></title>
    </head>
    <body>
    
    <div class="container" style="margin-bottom: 3px">
        <div class="row" style="margin: 0; padding:0;">
            <div class="col m8" style="padding: 0; border-right: 3px solid black; margin: 0;">
                <div class="slider" style="height: 440px;">
                    <ul class="slides" style="height: 400px;">
                        <li class="active" style="opacity: 1; display: block;">
                            <img src="<?php echo $product->image_url?> "> <!-- random image -->
                            <div class="caption center-align" style="opacity: 1; transform: translateX(0px) translateY(0px);">
                                <h3><?php echo $product->name;?></h3>
                                
                            </div>
                        </li>
                    </ul>
                <ul class="indicators"></ul></div>
                <div class="description" style="padding-left: 3px;">
                    <h1>Description</h1>
                    <p style="font-size: 18px;"><?php echo $product->description;?></p>
                    
                </div>
            </div>
            <div class="col m4">
                <div class="center border-left">
                    <h1><?php echo $product->name;?></h1>

                    <h4><?php echo "$product->price"."$";?></h4>
                    <?php
                       echo '<br>';
                    echo'Qualify: <br>
                            <span id="Stars'.$_GET['id'].'"></span>';
                    ?>
<h4>
<form id="form" action="../../backend/buttons/addtocart.php?id=<?php echo $_GET['id'];?>" method="POST" class="topBefore">
<label for="quantity" class="">Number of this products you want to add in the cart:</label>
<input type="number" name="quantity" min="1">
</h4>
  <button type="submit" class="waves-effect waves-light btn red" name="action">Add to the cart</button>
  <a class="waves-effect waves-light btn red"onclick="history.back()">Go back</a>
</form>

                </div>
            </div>
        </div>
    </div>

    <script src="../public/js/materialize.min.js"></script>
    <!--Jquery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!--Jquery Stars-->
    <script src="../public/starrr.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });
        <?php $starsystem = new Star();
        $starsystem->set($_GET['id']);
        $starsystem->editable($_SESSION['user_id']);  //this print all the rating star sistem, ?>
        
    </script>


</body></html>		