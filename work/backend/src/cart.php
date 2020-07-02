<?php 
require_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
class cart
{
    var $pquantity=0;               //the cart save al the information about the shopping database
    var $pdelivery=array();        // use its methods to easy add or eliminate items in the database
    var $p_id=array();
    var $cart_table_id=array();
    var $quantity=array();
    
 function addProduct($cart_table_id,$product_id,$quantity)
 {
     $this->pquantity=$this->pquantity+$quantity;            //add a product
     $this->p_id[$cart_table_id]=$product_id;               //only used when innit bacause its automatic get the item
     $this->cart_table_id[$cart_table_id]=$cart_table_id;  // before send it to the database
     $this->quantity[$cart_table_id]=$quantity;
 }
 function init($the_id)
 {
//obtain all the information in the database to fill the cart

     $conn=connect();
     $sql="SELECT * FROM shopping_cart WHERE user_id='$the_id'";
     if($rest_u=mysqli_query($conn,$sql))
     {
         while($row =mysqli_fetch_array($rest_u))    //to get all the information back from the database
         {
             $this->addProduct($row['id'],$row['product_id'],$row['quantity']);
         }
     }
     mysqli_close($conn);
 }
 function changeQuantity($cart_table_id,$value)
 
 {
 	$this->pquantity=$this->pquantity-$this->quantity[$cart_table_id];
 	$this->quantity[$cart_table_id]=$value;
 	$this->pquantity=$this->pquantity+$value;                             //change product group quantity
 	
 }
 function delProduct($cart_table_id,$quantity)
 {
     $this->pquantity=$this->pquantity-$this->quantity[$cart_table_id];
     $this->pdelivery[$cart_table_id]=NULL;
     $this->p_id[$cart_table_id]=NULL;
     $this->cart_table_id[$cart_table_id]=NULL;   //delete a specified item of the cart //delete a product group
     $this->quantity=NULL;
 }
 function reset()
 {
      $this->pquantity=0;
      $this->pdelivery=array();
      $this->p_id=array();
      $this->cart_table_id=array();    //destroy all items in the cart         //delete all the products groups
 }
 function show($cart_table_id) 
 {
 	 $return=0;
     $conn=connect();
     $temporal=$this->p_id[$cart_table_id];
     $sql_u = "SELECT * FROM products WHERE id='$temporal'";
     $res_u = mysqli_query($conn, $sql_u);
     $row =mysqli_fetch_array($res_u);
     $name=$row['name'];
     $price=$row['price'];          //this method is to be used to show all the data in cart page table
     {                             
         
     
     echo'</tbody>
          <tr>';
                       echo '</span>
                    <td>'.$name.'</td>
                    <td>'.$price.'$</td>
                    <td>'.$this->quantity[$cart_table_id].'</td>';
                          echo  '<td>'.$this->quantity[$cart_table_id]*($price).'$</td>';
                          $return=$this->quantity[$cart_table_id]*($price);
              echo'
                    <td>
                        <a href="../../backend/buttons/delete.php?id='.$cart_table_id.'"><button class="btn green waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Delete">
                            <i class="material-icons">delete</i>
                        </button></a>
                          <a class="green waves-effect waves-light tooltipped btn modal-trigger" data-position="bottom" data-tooltip="Change Quantity" href="#modalq'.$cart_table_id.'">
                          <i class="material-icons">edit</i>
                          </button></a>
                        <a href="../../backend/buttons/buy.php?id='.$cart_table_id.'&delivery=0"><button class="btn green waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Buy and Pick Up">
                            <i class="material-icons">person</i>
                        </button></a>
                        <a href="../../backend/buttons/buy.php?id='.$cart_table_id.'&delivery=1"><button class="btn green waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Buy with delivery for 5 more dollars">
                            <i class="material-icons">airport_shuttle</i>
                        </button></a>

                        
                        
                        <!-- Modal Structure  Quantity -->
    <div id="modalq'.$cart_table_id.'" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Change Quantity</h4>
      <p class ="center" style="margin-top:15%">
      <h4>
<form id="form'.$cart_table_id.'" action="../../backend/buttons/quantity.php?id='.$cart_table_id.'" method="POST" class="topBefore">
<label for="quantity" class="">Number of this products you want to add in the cart:</label>

<input type="number" name="quantity" min="1">
<h4>
</p>
    </div>
    <div class="modal-footer">
      <a class="modal-close waves-effect waves-green btn-flat">Cancel</a>
      <button type="submit" class="waves-effect waves-light btn red" name="action">Change Quantity</button>
      </form>
  </div>
  <!-- Modal Structure Quantity -->
  
  
                    </td>
                </tr>
            </tbody>';
              return $return;
     }
 }
 
 function showAll()
 {
 	$return=0;
     foreach ($this->cart_table_id as &$element) {
         $return = $return+($this->show($element)); //this method used to show all the data in cart page table
     }
     return $return;
 }
 
}
//*********************************************old_code***********************************************
//this code only was intended to be use in lastask when i was thinking the price of the delivery
//was per product instead of the whole buy
//is you want to see this version
//go to twitter.zz.com.ve
 function changeProduct($cart_table_id,$true_or_false)
 {
         $this->pdelivery[$cart_table_id]=$true_or_false;              //change product group delivery
 }

?>