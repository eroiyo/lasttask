<?php 
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/cart.php' );
class user
{
    var $username ="";
    var $money=0;
    var $user_id=0;
    var $cart = null;
    
    function init($the_id)   //this is the most complex class
    {
        $conn=connect();                                           //this class recolect
        $sql="SELECT * FROM users WHERE user_id='$the_id'";       //information from the database related to user
        if($rest_u=mysqli_query($conn,$sql))                     //and use it in practical ways
        {
            $row =mysqli_fetch_array($rest_u);
            $this->username= $row['username'];
            $this->money= $row['money'];
            $this->user_id=$row['user_id'];                 //getting information in the database
        }
        mysqli_close($conn);
    }
    function getCart($cart)                          //when i get a cart, i can manipulate
    {                                               //all the items of the user
        $this->cart=$cart;
    }
    function pushCart($product_id,$quantity) {
    	$conn=connect();
    	$query = ("SELECT * FROM shopping_cart WHERE product_id= '$product_id' AND user_id ='$this->user_id'");
		$result = mysqli_query($conn,$query);
		if((mysqli_num_rows($result) > 0))
		{
		$row=mysqli_fetch_array($result);
		$quantityof=$row['quantity'];
		$query= "UPDATE shopping_cart
        SET quantity = '$quantity+$quantityof'      
        WHERE product_id= '$product_id' AND user_id ='$this->user_id'";
		$result = mysqli_query($conn,$query);
		}
		else 
		{
		        $query= "INSERT INTO shopping_cart(user_id,product_id,quantity,delivery) VALUES ('$this->user_id','$product_id','$quantity',0)";       //obtain information about a product
        if($results = mysqli_query($conn, $query))                       //to add to the cart
        {
            $last_id =mysqli_insert_id($conn);
            $this->cart->addProduct($last_id, $product_id,$quantity);
        }
		}
        mysqli_close($conn);
        
        
    }
    function outCart($cart_table_id) 
    {
        $conn=connect();
        $query= "DELETE FROM shopping_cart WHERE id='$cart_table_id'";
        if($results = mysqli_query($conn, $query) && $this->security($cart_table_id)) //eliminate one item from the cart
        {
            $this->cart->delProduct($cart_table_id); 
        }
        mysqli_close($conn);
    }
    function deleteCart()
    {
        $conn=connect();
        $query= "DELETE FROM shopping_cart WHERE user_id='$this->user_id'";
        if($results = mysqli_query($conn, $query)) //eliminate all the items from the cart
        {                                                        //destroying all the items relationed to the user in the database
            $this->cart->reset(); //putting it in original state
        }
        mysqli_close($conn);
    }
    
    function buy($cart_table_id,$delivery) 
    {
        $sql_u = "SELECT * FROM shopping_cart WHERE id='$cart_table_id'";
        $conn=connect();
        $res_u=mysqli_query($conn, $sql_u);                           //eliminate a item from the cart
        $row =mysqli_fetch_array($res_u);                            //and consuming money from the account
        $product_id=$row['product_id'];
        $quantity=$row['quantity'];
        
        $sql_u = "SELECT * FROM products WHERE id='$product_id'";  //obtain all the data related to the item
        $res_u=mysqli_query($conn, $sql_u);
        $row =mysqli_fetch_array($res_u);
        if(($quantity*($row['price'])+$delivery)<=$this->money && $this->security($cart_table_id)) //looking is the user can affort
        {
            $this->money=$this->money -($quantity*($row['price'])+$delivery);   //reducing money from te account
            
            $sql_u ="UPDATE users SET money=$this->money WHERE user_id=$this->user_id"; //update database
            $res_u=mysqli_query($conn, $sql_u);
            $this->outCart($cart_table_id);
            mysqli_close($conn);
        }
        else //l
        {
            $_SESSION['moneyless']=true;
            header('Location: /work/frontend/views/cart_page.php'); //in contrary case, get a alert;
            
        }
        
        
    }
    function buyAll($delivery)
    {
        $sql_u = "SELECT * FROM shopping_cart WHERE user_id='$this->user_id'";  //the same as buy but target all the
        $conn=connect();                                                       //items in the database where the user it is in
        $products_price=0;
        $res_u=mysqli_query($conn, $sql_u);
        while($row =mysqli_fetch_array($res_u))
        {
            $product_id=$row['product_id'];
            $quantity=$row['quantity'];
            $sql_u = "SELECT * FROM products WHERE id='$product_id'"; //obtain information about the product to get 
            $res_ub=mysqli_query($conn, $sql_u);                     //prices
            $rowb =mysqli_fetch_array($res_ub);
            
            $products_price=($products_price)+$rowb['price']*$quantity;         //sumatory of all products
        }
        if(($products_price+$delivery)<$this->money )  //is the user can affort it
        {
            $this->money=$this->money-($products_price+$delivery);
            
            $sql_u ="UPDATE users SET money=$this->money WHERE user_id=$this->user_id";
            $res_u=mysqli_query($conn, $sql_u);           //pay it
            $this->deleteCart();
            mysqli_close($conn);
        }
        else
        {
            $_SESSION['moneyless']=true; //in contrary case, get a alert;
            header('Location: /work/frontend/views/cart_page.php');
            
        }
    }
    function security($cart_table_id)
    {
        $conn=connect();
        $query= "SELECT * FROM shopping_cart WHERE id='$cart_table_id'";
        $result = mysqli_query($conn,$query);
        $row =mysqli_fetch_array($result);
        if($row["user_id"]==$this->user_id)
        {
            return true;                   //this function verify is the connected user is the authorized user
        }                                 //to erase the items from the database
        return false; 
    }
    function quantityCart($cart_table_id,$value)
    {
        $conn=connect();
        $query= "UPDATE shopping_cart
        SET quantity = '$value'            
        WHERE id = '$cart_table_id'";
        if($results = mysqli_query($conn, $query) && $this->security($cart_table_id))
        {
            $this->cart->changeQuantity($cart_table_id,$value); //update the quantity of a group of products
        }
        mysqli_close($conn);
    }
    function ifconnprint($string)
    {
        if(($this->username !="")&& ($this->user_id!=0))
        {
            echo $string;                      //print in case the user is connected
        }
    }
    function ifconnprintorelse($stringa,$stringb)
    {
        if(($this->username !="")&& ($this->user_id!=0))
        {
            echo $stringa;                      //print is the user connected is not, print other thing
        }                                      //only used in index
        else 
        {
            echo $stringb;
        }
    }
}
//*********************************************old_code***********************************************
//this code only was intended to be use in lastask when i was thinking the price of the delivery
//was per product instead of the whole buy
//is you want to see this version
//go to twitter.zz.com.ve
    function old_pushCart($product_id,$quantity,$transport) 
    {
        $conn=connect();
        $query= "INSERT INTO shopping_cart(user_id,delivery,product_id,quantity) VALUES (".$this->user_id.",".$transport.",".$product_id.",".$quantity.")";       //obtain information about a product
        if($results = mysqli_query($conn, $query))                       //to add to the cart
        {
            $last_id =mysqli_insert_id($conn);
            $this->cart->addProduct($last_id, $product_id,$transport,$quantity);
        }
        mysqli_close($conn);
        
        
    }
        function modifyCart($cart_table_id,$true_or_false)
    {
        $conn=connect();
        $query= "UPDATE shopping_cart
        SET delivery = '$true_or_false'            
        WHERE id = '$cart_table_id'";
        if($results = mysqli_query($conn, $query) && $this->security($cart_table_id))
        {
            $this->cart->changeProduct($cart_table_id,$true_or_false); //change delivery type
        }
        mysqli_close($conn);
    }
        function old_buy($cart_table_id) {
        $sql_u = "SELECT * FROM shopping_cart WHERE id='$cart_table_id'";
        $conn=connect();
        $delivery_price=0;
        $res_u=mysqli_query($conn, $sql_u);                           //eliminate a item from the cart
        $row =mysqli_fetch_array($res_u);                            //and consuming money from the account
        $delivery=$row['delivery'];
        $product_id=$row['product_id'];
        $quantity=$row['quantity'];
        
        $sql_u = "SELECT * FROM products WHERE id='$product_id'";  //obtain all the data related to the item
        $res_u=mysqli_query($conn, $sql_u);
        $row =mysqli_fetch_array($res_u);
        $delivery_price=0;
        if(($delivery==true) && ($row['free_delivery']==false))   //looks its is the delivery prices apply or not
        {
            $delivery_price=$delivery_price+5;
        }
        if(($quantity*($row['price']+$delivery_price))<=$this->money && $this->security($cart_table_id)) //looking is the user can affort
        {
            $this->money=$this->money -($quantity*($row['price']+$delivery_price));   //reducing money from te account
            
            $sql_u ="UPDATE users SET money=$this->money WHERE user_id=$this->user_id"; //update database
            $res_u=mysqli_query($conn, $sql_u);
            $this->outCart($cart_table_id);
            mysqli_close($conn);
        }
        else //l
        {
            $_SESSION['moneyless']=true;
            header('Location: /work/frontend/views/cart_page.php'); //in contrary case, get a alert;
            
        }
        
        
    }
        function old_buyAll()
    {
        $sql_u = "SELECT * FROM shopping_cart WHERE user_id='$this->user_id'";  //the same as buy but target all the
        $conn=connect();                                                     //items in the database where
        $delivery_price=0;                                                 //the user it is in
        $products_price=0;
        $res_u=mysqli_query($conn, $sql_u);
        while($row =mysqli_fetch_array($res_u))
        {
            $delivery=$row['delivery'];
            $product_id=$row['product_id'];
            $quantity=$row['quantity'];
            $sql_u = "SELECT * FROM products WHERE id='$product_id'"; //obtain information about the product to get 
            $res_ub=mysqli_query($conn, $sql_u);                     //prices
            $rowb =mysqli_fetch_array($res_ub);
            
            $products_price=($products_price)+$rowb['price']*$quantity;         //sumatory of all products
            if(($delivery==true) && ($rowb['free_delivery']==false))
            { 
                $delivery_price=$delivery_price+(5*$quantity);  //adding delivery price it is needed
            }
        }
        if(($products_price+$delivery_price)<$this->money )  //is the user can affort it
        {
            $this->money=$this->money-($products_price+$delivery_price);
            
            $sql_u ="UPDATE users SET money=$this->money WHERE user_id=$this->user_id";
            $res_u=mysqli_query($conn, $sql_u);           //pay it
            $this->deleteCart();
            mysqli_close($conn);
        }
    }
?>