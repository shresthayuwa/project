<?php
include("connect.php");
session_start();
if (!isset($_SESSION["username"])) {
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
    <div class="nav_bar">
        <div class="nav_bar_left">
        <h1>User</h1>
        </div>
        <div class="nav_bar_two">
            <ul>
                <li><a href="view.html">View</a></li>
                <li><a href="aboutus.html">About Us</a></li>
            </ul>
        <button onclick="document.location='logout.php'" class="logout">Logout</button>
        </div>
    </div>

    <h1>Welcome to your dashboard <?php echo $_SESSION["username"]; ?></h1>


    <div class="ticket_container">
        <h1>Available buses</h1>

        <div class="ticket_grid">
        <!-- Code to check if there are any available tickets -->
        <?php
        $query = "SELECT * FROM ticket";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>

                <div class="collection_ticket">
                    <form method="post">
                        <label for="bus-id">Bus no: <?php echo ($row['bus_id']); ?></label>
                        <br><br>
                        <label for="pickup-point">Pickup Point: <?php echo ($row['pickup']); ?></label>
                        <br><br>
                        <label for="destination-point">Destination Point: <?php echo ($row['destination']); ?></label>
                        <br><br>
                        <label for="date">Date: <?php echo ($row['date']); ?></label>
                        <br><br>
                        <label for="price">Price: Rs <?php echo ($row['price']); ?></label>
                        <br><br>
                        <button type="button" class="ticket_button" onclick="document.location='logic.html'">Update Ticket</button>
                    </form>
                </div>

                <?php
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        ?>
        </div> <!-- End of grid container -->
    </div>

</body>

</html>
