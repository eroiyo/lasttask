<?php
include_once( $_SERVER['DOCUMENT_ROOT'].'/work/backend/src/conection.php' );
class Star
{
	//this is needed to print all the information in the star system library
	var $product_id=0;
	
	function set($id)
	{
		$this->product_id=$id;
	}
	function average() 
	{
		
		$return=0;
		$votes=0;
		$conn= connect();
		$query = ("SELECT * FROM star_rating WHERE product_id= ".$this->product_id."");
        if($result = mysqli_query($conn,$query))
        {
            while($row =mysqli_fetch_array($result))  //promediate the value of the rating system
        {
        	$return=$return+$row['rating'];
        	$votes++;
        }
        if($votes>0){
        $return =round(($return/$votes), 0, PHP_ROUND_HALF_UP);
        if($return>1)
        {
        return $return;
        }
        }
        	return 1;
        }
	}
	function save($user_id,$value)
	{
		//get the vote of the user, in case of the user already voted it will change its old vote
		$conn= connect();
		$query = ("SELECT * FROM star_rating WHERE product_id= '$this->product_id' AND user_id ='$user_id'");
		$result = mysqli_query($conn,$query);
		if((mysqli_num_rows($result) > 0))
		{
		$query= "UPDATE star_rating
        SET rating = '$value'            
        WHERE product_id= '$this->product_id' AND user_id ='$user_id'";       // unused edit vote option
		$result = mysqli_query($conn,$query);
		}
		else
		{
			$query="INSERT INTO star_rating(user_id,rating,product_id) VALUES ('$user_id','$value','$this->product_id')";
			$result = mysqli_query($conn,$query);
		}
	}
	function editableindex()
	{
		//print the javascript needed for the star system button an activate the star->save function
		//return user to the index
		echo 
        "
        $('#Stars".$this->product_id."').starrr({
            rating: ".$this->average().",
            change: function(e, value) {
                newUrl='http://lasttask.zz.com.ve/work/backend/buttons/qualifyindex.php?product_id=".$this->product_id."&value='+value;
                document.location.href = newUrl;
            }})
            ";
	}
	function editable($user_id)
	{
		//print the javascript needed for the star system button an activate the star->save function
		//return user to the product_page
		$conn=connect();
	    $query = ("SELECT * FROM star_rating WHERE product_id= '$this->product_id' AND user_id ='$user_id'");
	    $result2 = mysqli_query($conn,$query);
	    if((mysqli_num_rows($result2) > 0))
	    {
	        $this->readonly();
	    }
	    else
	        {
		echo 
        "$('#Stars".$this->product_id."').starrr({
            rating: ".$this->average().",
            change: function(e, value) {
                newUrl='http://lasttask.zz.com.ve/work/backend/buttons/qualify.php?product_id=".$this->product_id."&value='+value;
                document.location.href = newUrl;
            }})";
	        }
	}
	function readonly()
	{echo
	    "$('#Stars".$this->product_id."').starrr({
            rating: ".$this->average().",
            readOnly: true
})
";
	}
    function editableindexAll($user_id)
    {
        //show many times equals to products diversity
        $temp=0;
        $conn = connect();
        $query = ("SELECT * FROM products");
        $result = mysqli_query($conn,$query);
        while($row =mysqli_fetch_array($result))
        {
            $conn2 = connect();
            $this->set($row['id']);
            $query2 = ("SELECT * FROM star_rating WHERE product_id= '$this->product_id' AND user_id ='$user_id'");
            $result2 = mysqli_query($conn2,$query2);
            if((mysqli_num_rows($result2) > 0))
            {
                $this->readonly();
            }
            else
            {
                $this->editableindex();
            }
        }
    }
    
}

?>