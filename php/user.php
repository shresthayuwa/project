<?php
session_start();
if(!isset($_SESSION["username"]))
{

    header("location:login.php");
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>welcome to your dashboard <?php echo $_SESSION["username"]; ?></h1> 
        <button onclick="document.location='logout.php'">logout</button>
    </div>
</body>
</html>
