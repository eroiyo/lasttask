<?php
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/user.php');
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/products.php');
                                             //there is the cart page
session_start();
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
    header('Location: /work/frontend/views/login.php');  // if you no are connected you cant stay here
}
if(isset($_SESSION['moneyless']))
{
    echo '<script language="javascript">';
    echo 'alert("you dont have sufficient money")';  //this script only appear when you try to buy a item
}                                                   // but dont have money
    echo '</script>';                             //if you wanna know the origin got to user.php -> buy() and buyAll()
    unset($_SESSION['moneyless']);                   
?>                        

<!DOCTYPE html>
<html>                        
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
</head>

<body>

    <nav class="lime accent-1">
        <div class="nav-wrapper">
        <a href="../../backend/buttons/extramoneyb.php" class="brand-logo orange-text right"><?php echo($client->money."$")?></a>
                      <?php  
                      echo
                      ('<a href="cart_page.php" class="brand-logo orange-text center">Cart</a>');
                      ?> 
            <div class="container">
                <a href="index.php" class="brand-logo blue-text left">Last Task</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">

        <?php echo('<li><a href="·" class=" blue-text">'.$client->username.'</a></li>')?>
 
        <li><a href="cart_page.php"><i class="material-icons blue-text">add_shopping_cart</i></a></li>
 
        <li><a class="brand-logo orange-text"><?php echo($client->cart->pquantity); ?></a></li>
 
      </ul> 
                    
                </ul>
            </div>
        </div>
    </nav>

    <div class="container section center">
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Item Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <?php $total=$client->cart->showAll(); ?>
        </table>
        <?php
        if($total>0)
        {
           echo ' 
      <p>
      <label>
        <input  name="toggler" type="radio" value="1"  />
        <span>Pick Up</span>
      </label>
    </p>
    <p>
      <label>
        <input  name="toggler" type="radio" value="2"  />
        <span>UPS</span>
      </label>';
           echo'
<div id="blk-1" style="display:none">
<p><a href="../../backend/buttons/buyall.php?delivery=0"<button class="btn lime waves-effect waves-orange" style="margin-top: 30px; width: 50%;">Buy And pick up for  '.$total.'$</a></p>
</div>
<div id="blk-2" style="display:none">
<p><a style="display: none"><a href="../../backend/buttons/buyall.php?delivery=1"<button class="btn lime waves-effect waves-orange" style="margin-top: 30px; width: 50%;">Buy All with delivery for  '.($total+5).'$</a></p>
</div>
<div id="blk-3">
<p><a><a class="btn disabled style="margin-top: 30px; width: 50%;"">Please select a delivery type</a></p>
           
</div>';}?>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });
        $(function() {
            $("[name=toggler]").each(function(i) {
                $(this).change(function(){
                    $('#blk-1, #blk-2, #blk-3').hide();
                    divId = 'blk-' + $(this).val();
                    $("#"+divId).show('slow');
                });
            });
         })
    </script>
</body>


</html>