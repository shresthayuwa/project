<?php
include("connect.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("location:login.php");
}

// Fetch available buses from the database
$query = "SELECT * FROM ticket";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user.css">
    <title>User Panel</title>
</head>

<body onload="greetUser()">
    <div class="wrapper">

        <!-- Header Section -->
        <div class="header">
            <div class="logo">
                <a href="homepage.html">BusEase</a>
            </div>
        </div>

        <!-- Navigation Bar -->
        <div class="nav">
            <div class="nav1">
                <h1>User Panel</h1>
            </div>
            <div class="nav2">
                <ul>
                    <li><a class="l_button" href="ViewBookedTickets.php">View Booked Tickets</a></li>
                    <li><a class="l_button" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <h3 id="greeting">Welcome <?php echo $_SESSION["username"]; ?>!</h3>

            <div class="ticket_container">
                <h1>Available Buses</h1>
                    <br>
                <div class="ticket_grid">
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>

                        <div class="collection_ticket">
                            <form method="post" action="logic.php">
                                <div style="text-align: center; font-weight: bold">
                                    <label for="bus-id">Bus code: <?php echo ($row['bus_id']); ?></label>
                                    <input type="hidden" name="bus_id" value="<?php echo $row['bus_id']; ?>">
                                </div>
                                <br><br>
                                <label for="pickup-point">Pickup Point: <?php echo ($row['pickup']); ?></label>
                                <br><br>
                                <label for="destination-point">Destination Point: <?php echo ($row['destination']); ?></label>
                                <br><br>
                                <label for="date">Date: <?php echo ($row['date']); ?></label>
                                <br><br>
                                <label for="price">Price: Rs <?php echo ($row['price']); ?></label>
                                <br><br>
                                <button type="submit" class="ticket_button">Select Ticket</button>
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
        </div>

        <div class="clear"></div>

        <!-- Footer Section -->
        <div class="footer">
            <p>&copy; 2024, All Rights Reserved,<br>Designed by: <b>BusEase</b></p>
        </div>

    </div>

    <script>
        function greetUser() {
            const greetingElement = document.getElementById("greeting");
            const currentTime = new Date();
            const hours = currentTime.getHours();

            let greetingMessage = "Good Morning";
            if (hours >= 12 && hours < 18) {
                greetingMessage = "Good Afternoon";
            } else if (hours >= 18) {
                greetingMessage = "Good Evening";
            }

            const username = "<?php echo $_SESSION['username']; ?>";
            greetingElement.textContent = greetingMessage + " " + username + "!";
        }
    </script>

</body>
</html>
