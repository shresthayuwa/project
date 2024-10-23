<?php
    include("connect.php");
    session_start();

    // Check if the admin is logged in, otherwise redirect to login page
    if (!isset($_SESSION["username"])) {
        header("location:login.php");
    }

    // Handle form submission for setting a ticket
    if (isset($_POST['set-ticket'])) {
        $pickup = $_POST['pickup-point'];
        $destination = $_POST['destination-point'];
        $date = $_POST['date'];
        $price = $_POST['price'];
        
        // Insert the new ticket information into the database
        $query = "INSERT INTO ticket (`pickup`, `destination`, `date`, `price`) VALUES ('$pickup', '$destination', '$date', '$price');";

        // Check if the query was successful
        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Ticket set successfully");</script>';
        } else {
            echo '<script>alert("Error occurred while setting the ticket");</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
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
                <h1>Admin Panel</h1>
            </div>
            <div class="nav2">
                <ul>
                    <li><a class="l_button" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <div class="info">

            <!-- Total Users Display -->
                <div class="pop_count">
                    <h2>Total Users:
                        <?php
                        $query = "SELECT COUNT(*) AS total_users FROM user WHERE usertype='user'";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            printf("%d", $row['total_users']);
                        } else {
                            echo "Query failed: " . mysqli_error($conn);
                        }
                        ?>
                    </h2>
                    <button type="submit" onclick="document.location='viewuser.php'" class="pop_count_button">View Users</button>
                </div>

            <!-- Total Admins Display -->
                <div class="pop_count" >
                    <h2>Total Admins:
                        <?php
                        $query = "SELECT COUNT(*) AS total_admins FROM user WHERE usertype='admin'";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            printf("%d", $row['total_admins']);
                        } else {
                            echo "Query failed: " . mysqli_error($conn);
                        }
                        ?>
                    </h2>
                    <button type="submit" onclick="document.location='viewadmin.php'" class="pop_count_button">View Admins</button>
                </div>

            <!-- Total Buses Display -->
                <div class="pop_count">
                    <h2>Total Buses:
                        <?php
                        $query = "SELECT COUNT(*) AS total_buses FROM ticket";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            printf("%d", $row['total_buses']);
                        } else {
                            echo "Query failed: " . mysqli_error($conn);
                        }
                        ?>
                    </h2>
                    <button type="submit" onclick="document.location='viewbus.php'" class="pop_count_button">View Buses</button>
                </div>

            <!-- Expected Revenue Display -->
                <div class="pop_count" id="seperate">
                    <h2>Expected revenue:
                        <?php
                        $query = "SELECT SUM(price) as sum FROM booked_seats";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            printf("Rs. %d", $row['sum']);
                        } else {
                            echo "Query failed: " . mysqli_error($conn);
                        }
                        ?>
                    </h2>
                </div>

            <!-- View Requests -->
                <div class="pop_count" id="seperate">
                   <h2>View Requests</h2>
                   <button type="submit" onclick="document.location='viewrequests.php'" class="pop_count_button">View Requests</button>
                </div>
            </div>

            <!-- Ticket Set Form -->
            <div class="ticket_setter">
                <form method="post">
                    <legend>Bus Time</legend>
                    <label for="pickup-point">Pickup: </label>
                    <select name="pickup-point" id="pickup-point" required>
                        <option value="" disabled selected hidden>Select your pickup point</option>
                        <option value="Kathmandu">Kathmandu</option>
                        <option value="Bhaktapur">Bhaktapur</option>
                        <option value="Lalitpur">Lalitpur</option>
                        <option value="Kirtipur">Kirtipur</option>
                        <option value="Hetauda">Hetauda</option>
                    </select>
                    <br><br>
                    <label for="destination-point">Destination: </label>
                    <select name="destination-point" id="destination-point" required>
                        <option value="" disabled selected hidden>Select your destination</option>
                        <option value="Kathmandu">Kathmandu</option>
                        <option value="Bhaktapur">Bhaktapur</option>
                        <option value="Lalitpur">Lalitpur</option>
                        <option value="Kirtipur">Kirtipur</option>
                        <option value="Hetauda">Hetauda</option>
                    </select>
                    <br><br>
                    <label for="date">Set time: </label>
                    <input type="date" id="date" name="date" placeholder="Set your date" required>
                    <br>
                    <label for="price">Ticket Price: </label>
                    <input type="number" id="price" name="price" placeholder="Enter the ticket price" min="10" required>
                    <br><br>
                    <button type="submit" name="set-ticket" value="set-ticket" class="admin_ticket_selector">Set Ticket</button>
                </form>
            </div>
        </div>

        <div class="clear"></div>

        <!-- Footer Section -->
        <div class="footer">
            <p>&copy; 2024, All Rights Reserved,<br>Designed by: <b>BusEase</b></p>
        </div>

    </div>

    <!-- Script for preventing submission if the selected date is in the past or pickup/destination are the same -->
    <script>
        // Get today's date
        var today = new Date();
        
        // Format the date as YYYY-MM-DD
        var day = (today.getDate() < 10 ? '0' : '') + today.getDate();  // Add '0' if day is less than 10
        var month = (today.getMonth() + 1 < 10 ? '0' : '') + (today.getMonth() + 1);  // Add '0' if month is less than 10
        var year = today.getFullYear();
        
        // Set the minimum date attribute to today (format: YYYY-MM-DD)
        var minDate = year + '-' + month + '-' + day;
        document.getElementById('date').min = minDate;

        // Add form submission validation to prevent submission if the selected date is in the past or pickup/destination are the same
        document.querySelector('form').onsubmit = function() {
            var selectedDate = document.getElementById('date').value;
            var pickupPoint = document.getElementById('pickup-point').value;
            var destinationPoint = document.getElementById('destination-point').value;
            
            // If the selected date is earlier than today's date, show alert and return false to prevent form submission
            if (selectedDate < minDate) {
                alert('You cannot select a past date.');
                return false;  // Prevent form submission
            }
            
            // If pickup and destination points are the same, show alert and return false
            if (pickupPoint === destinationPoint) {
                alert('Pickup and destination cannot be the same.');
                return false;  // Prevent form submission
            }
            
            return true;  // Allow form submission if all validations pass
        };
    </script>
</body>

</html>
