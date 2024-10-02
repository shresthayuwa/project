<?php
include("connect.php");
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
    <link rel="stylesheet" href="../css/user.css">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>welcome to your dashboard <?php echo $_SESSION["username"]; ?></h1> 
        <button onclick="document.location='logout.php'">logout</button>
    </div>
    <div class="ticket_container">
    <?php
  $query = "SELECT * FROM ticket";
  $result = mysqli_query($conn, $query);
  
  // Check if the query was successful
  if ($result) {
      // Loop through each row and create a form
      while ($row = mysqli_fetch_assoc($result)) {
          ?>
          <form method="post">
              <label for="pickup-point">Pickup Point: <?php echo ($row['pickup']); ?></label>
                <br>
                <br>
              <label for="destination-point">Destination Point: <?php echo ($row['destination']); ?></label>
                <br>
                <br>
              <label for="date">Date: <?php echo ($row['date']); ?></label>
                <br>
                <br>
              <label for="price">Price: <?php echo ($row['price']); ?></label>
                <br>
                <br>
                <label for="ticket_id">Ticket no: <?php echo $row['ticket_id']; ?></label> 
                <br>
              <button type="submit">Update Ticket</button>
          </form>
          <?php
      }
  } else {
      echo "Error: " . mysqli_error($conn);
  }
    ?>
    </div>
</body>
</html>
