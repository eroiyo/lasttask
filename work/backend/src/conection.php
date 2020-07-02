<?php

function connect()
{
     $servern ="localhost";
     $dbusern ="eroiyo";
     $dbpassword ="88888888aA";
     $dbname="eroiyo";
     $conn = mysqli_connect($servern, $dbusern, $dbpassword,$dbname) or die("Connect failed: %s\n". $conn -> error);
     return $conn;
}

//i know i can`t use static methods, but this is a easy way to configure when you merge the page

?>