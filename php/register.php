<?php
//database lai connect garne code
include("connect.php");
//isset condition
if(isset($_POST['register'])){

$fullname=$_POST['fullname'];
$username=$_POST['username'];
$password=$_POST['password'];
$query=" INSERT INTO `user` (`fullname`, `username`, `password`, `usertype`) VALUES ('$fullname', '$username', '$password', 'user');";

if(mysqli_query($conn,$query)){

header("location: index.php");
}

else{
    echo"not registered successfully";
}
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <br>
    <br>
    <form method="post">
        <legend>Create an Account</legend>
        <input type="text" name="fullname" id="fullname" placeholder="Full name" required>
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <br>
        <br>
        <button type="submit" value="register" name="register" >Signup</button>
    </form>
    <p>Already have an account? <a href="index.php">Login here</a></p>
</body>
</html>

<!-- INSERT INTO `user` (`user_id`, `fullname`, `username`, `password`, `usertype`) VALUES (NULL, 'yuwa shrestha', 'yuwa', '123', 'user'); -->
<!-- INSERT INTO `user` (`user_id`, `fullname`, `username`, `password`, `usertype`) VALUES (NULL, 'admin', 'admin', 'admin123', 'admin'); -->