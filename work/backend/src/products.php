<?php
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
class Product
{
    var $id = 0;
    var $description ="";    ///there is the product class
    var $price=0;
    var $delivery=true;
    var $image_url="";   //the only thing it does is obtain the information from the database to project
    var $name="";       //in html
    function show()
    {
        echo '
        <div class="col m4">
        <div class="card">
        <div class="card-image">
        <img src='.$this->image_url.' class="materialboxed" height="210px" alt="">
        <span class="card-title black-text" style="font-weight: bold;">'.$this->name.'</span>
        </div>
        <div class="card-content">
        <p>'.$this->description.'</p>
        <p class="left">Qualify: <span id="Stars'.$this->id.'"></span></p>
        </div>
        <div class="card-action center">
        <h4>'.$this->price.'$</h4>
        <a href="product_page.php?id='.$this->id.'" class="section btn lime waves-effect waves-yellow">More information</a>
        </div>
        </div>
        </div>
';
    }
    function showAll()
    {
        echo '<div class="row section">';   //show many times equals to products diversity
        $temp=0;
        $conn = connect();
        $query = ("SELECT * FROM products");
        $result = mysqli_query($conn,$query);
        while($row =mysqli_fetch_array($result))
        {
            $temp++;
            $this->id = $row['id'];
            $this->description =$row['description'];
            $this->price=$row['price'];
            $this->delivery=$row['free_delivery'];
            $this->image_url=$row['image_url'];
            $this->name=$row['name'];
            $this->show();
            if($temp>=3)
            {
                $temp=0;
                echo '<div class="row"></div>';
            }
        }
        echo '</div>';
        mysqli_close($conn);
        
    }
    function set($id)
    {
        $conn = connect();
        $query = ("SELECT * FROM products WHERE id = ".$id); //obtain all the information about 1 product
        $result = mysqli_query($conn,$query);
        $row =mysqli_fetch_array($result);
        
        $this->id = $row["id"];
        $this->description =$row["description"];
        $this->price=$row["price"];
        $this->delivery=$row["free_delivery"];
        $this->image_url=$row["image_url"];
        $this->name=$row["name"];
        mysqli_close($conn);
    }
}

?>