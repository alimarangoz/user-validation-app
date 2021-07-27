<?php
session_start();
if(!isset($_SESSION["name"])){
    header("Location:logout.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Page</title>
</head>
<body>

<h1 style="text-align: center"><i><b>Tebrikler Hala Hayattasınız </b></i></h1>
<button style="margin-left: 45%; border-radius: 8px; padding: 4px 4px 4px 4px"><a style="text-decoration: none;color: darkblue" href="login.php">Go Back To Login</a></button>
</body>
</html>