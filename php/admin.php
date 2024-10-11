<?php
include("connect.php");
session_start();
if(!isset($_SESSION["username"]))
{

    header("location:login.php");
}


if(isset($_POST['set-ticket']))
{
    $pickup=$_POST['pickup-point'];
    $destination=$_POST['destination-point'];
    $date=$_POST['date'];
    $price=$_POST['price'];
    $query = "INSERT INTO ticket (`pickup`, `destination`, `date`, `price`) VALUES ('$pickup', '$destination', '$date', '$price');";
    if(mysqli_query($conn,$query))
    {
        echo'<script>alert("ticket set");</script>';
    }
    else{
        echo'<script>alert("error has occured");</script>';
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="welcome-board">
    <h1>Admin panel</h1>
    <button onclick="document.location='logout.php'" class="logout_button">Log out</button>
    </div>
    
    <div class="container">



    <div class="info">

    <div class="pop_count">
        <h2>Total Users: <?php
        $query = "SELECT COUNT(*) AS total_users FROM user WHERE usertype='user'";
        $result = mysqli_query($conn, $query);
        if ($result) {
        $row = mysqli_fetch_assoc($result);
        printf("%d", $row['total_users']);
        } else {
            echo "Query failed: " . mysqli_error($conn);
        }
    ?></h2>
        
    <button type="submit" onclick="document.location='viewuser.html'" class="pop_count_button">View Users</button>
    </div>



    <div class="pop_count">
        <h2>Total Admins: <?php
        $query = "SELECT COUNT(*) AS total_admins FROM user WHERE usertype='admin'";
        $result = mysqli_query($conn, $query);
        if ($result) {
        $row = mysqli_fetch_assoc($result);
        printf("%d", $row['total_admins']);
        } else {
            echo "Query failed: " . mysqli_error($conn);
        }
    ?></h2>
        
    <button type="submit" onclick="document.location='viewadmin.html'" class="pop_count_button">View Admins</button>
    </div>


    <div class="pop_count">
        <h2>Total Buses: <?php
        $query = "SELECT COUNT(*) AS total_buses FROM ticket";
        $result = mysqli_query($conn, $query);
        if ($result) {
        $row = mysqli_fetch_assoc($result);
        printf("%d", $row['total_buses']);
        } else {
            echo "Query failed: " . mysqli_error($conn);
        }
    ?></h2>
        
    <button type="submit" onclick="document.location='viewbus.html'" class="pop_count_button">View Buses</button>
    </div>
    





    </div>













<!--yeta bata info sakinxa-->

    <div class="ticket_setter">
    <Form method="post">
        <legend>Bus Time</legend>
        <Label for="pickup-point">Pickup: </Label>
        <select name="pickup-point" id="pickup-point" placeholder="pickup">
            <option value="" disable selected hidden >Select your pickup point</option>
            <option value="Kathmandu">Kathmandu</option>
            <option value="Bhaktapur">Bhaktapur</option>
            <option value="Lalitpur">Lalitpur</option>
            <option value="Kirtipur">Kirtipur</option>
            <option value="Hetauda">Hetauda</option>
        </select>
        <br>
        <br>
        <label for="destination-point">Destination: </label>
        <select name="destination-point" id="destination-point" placeholder="destination">
            <option value="" disable selected hidden >Select your destination &nbsp; </option>
            <option value="Kathmandu">Kathmandu</option>
            <option value="Bhaktapur">Bhaktapur</option>
            <option value="Lalitpur">Lalitpur</option>
            <option value="Kirtipur">Kirtipur</option>
            <option value="Hetauda">Hetauda</option>
        </select>
        <br>
        <br>
        <label for="date">Set time: </label>
        <input type="date" id="date" name="date" placeholder="set your date">
        <br>
        <label for="price">Ticket Price</label>
        <input type="number" id="price" name="price" placeholder="enter the ticket price" min="10" value="">
        <br>
        <br>
        <button type="submit" name="set-ticket" value="set-ticket" class="admin_ticket_selector">Set Ticket</button>
    </form>
    </div>



    </div>
    
</body>
</html>
