<?php
include("connect.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("location:login.php");
}

$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user.css">
    <title>Your Booked Tickets</title>
</head>

<body>
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
                    <li><a class="l_button" href="user.php">User Panel</a></li>
                    <li><a class="l_button" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <h1>Your Booked Tickets</h1>
            <br>
            <p style="font-weight: bold; text-align: center;">Note: The booking fee will not be returned in case of cancellation.</p>
            <div class="ticket_container">
                <div class="ticket_grid">
                <?php
                // Query to fetch booked tickets along with seat numbers
                $query = "
                    SELECT ticket.bus_id, ticket.pickup, ticket.destination, ticket.date, ticket.price, booked_seats.seat
                    FROM ticket
                    JOIN booked_seats ON ticket.bus_id = booked_seats.bus_id
                    WHERE booked_seats.username = '$username'
                ";

                // Run the combined query
                $result = mysqli_query($conn, $query);

                if ($result) {
                    // Check if any records were returned
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="collection_ticket">
                                <div style="text-align: center; font-weight: bold">
                                    <label for="bus-id">Bus No: <?php echo $row['bus_id']; ?></label>
                                </div>
                                <br><br>
                                <label for="pickup-point">Pickup Point: <?php echo $row['pickup']; ?></label>
                                <br><br>
                                <label for="destination-point">Destination Point: <?php echo $row['destination']; ?></label>
                                <br><br>
                                <label for="date">Date: <?php echo $row['date']; ?></label>
                                <br><br>
                                <label for="price">Price: Rs <?php echo $row['price']; ?></label>
                                <br><br>
                                <label for="seat-no">Seat No: <?php echo $row['seat']; ?></label>
                                <br><br>
                                <!-- Form to cancel the booking -->
                                <form method="post" action="CancelBooking.php">
                                    <input type="hidden" name="bus_id" value="<?php echo $row['bus_id']; ?>">
                                    <input type="hidden" name="seat" value="<?php echo $row['seat']; ?>">
                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                    <button type="submit" class="cancel_button">Cancel Booking</button>
                                </form>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p style='text-align: center;'>No booked tickets found.</p>";
                    }
                } else {
                    echo "<p style='text-align: center;'>Error fetching data: " . mysqli_error($conn) . "</p>";
                }
                ?>
                </div>
            </div>
        </div>

        <div class="clear"></div>

        <!-- Footer Section -->
        <div class="footer">
            <p>&copy; 2024, All Rights Reserved,<br>Designed by: <b>BusEase</b></p>
        </div>
    </div>
</body>

</html>
