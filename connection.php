<?php

$username = "localhost";
$root = "root";
$password = "";
$dbname = "validation";

$conn = mysqli_connect($username,$root,$password,$dbname);

if(!$conn){
    echo "Connection Failed!";
}





?>
