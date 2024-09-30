<?php
include("connect.php");

session_start();

if(isset($_POST['log'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Query to select based on username only
    $query = "SELECT * FROM user WHERE username='$username'";
    $run = mysqli_query($conn, $query);
    
    // Check if a user was found
    if($run && mysqli_num_rows($run) > 0) {
        $row = mysqli_fetch_assoc($run);
        
        // Check if the provided password matches the stored password
        if($row['password'] == $password) {  // This is not secure; ideally, use password_verify()
            // Redirect based on usertype
            if($row['usertype'] == "user") {
                $_SESSION["username"]=$username;
                header("location: user.php");
                exit();  // It's good practice to exit after header redirection
            } elseif($row['usertype'] == "admin") {
                header("location: admin.php");
                exit();
            }
        } else {
            echo'<script>alert("Username or password is incorrect"); </script>';  // Password does not match
        }
    } else {
        echo'<script>alert("Username or password is incorrect"); </script>';  // Username does not exist
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <title>Login</title>
</head>
<body>
    <form method="post">
        <legend>Login Form</legend>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>
        <br>
        <br>
        <button type="submit" name="log" value="log">Login</button>
        <p>Don't have an account ? <a href="register.php">Signup here</a>.</p>
    </form>
</body>
</html>
