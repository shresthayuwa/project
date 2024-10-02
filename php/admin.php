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
    <h1>hello welcome to admin panel</h1>
    <button onclick="document.location='logout.php'">log out</button>
    </div>
    <Form method="post">
        <legend>Bus Time</legend>
        <Label for="pickup-point">Pickup: </Label>
        <select name="pickup-point" id="pickup-point" placeholder="pickup">
            <option value="" disable selected hidden>Select pickup point</option>
            <option value="kathmandu">Kathmandu</option>
            <option value="bhaktapur">Bhaktapur</option>
            <option value="lalitpur">Lalitpur</option>
            <option value="kirtipur">Kirtipur</option>
            <option value="hetauda">Hetauda</option>
        </select>
        <br>
        <br>
        <label for="destination-point">Destination: </label>
        <select name="destination-point" id="destination-point" placeholder="destination">
            <option value="" disable selected hidden>Select your destination</option>
            <option value="kathmandu">Kathmandu</option>
            <option value="bhaktapur">Bhaktapur</option>
            <option value="lalitpur">Lalitpur</option>
            <option value="kirtipur">Kirtipur</option>
            <option value="hetauda">Hetauda</option>
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
        <button type="submit" name="set-ticket" value="set-ticket">Set Ticket</button>
    </form>
</body>
</html>
