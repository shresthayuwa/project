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
                <h1>Admin Panel</h1>
            </div>
            <div class="nav2">
                <ul>
                    <li><a class="l_button" href="admin.php">Admin Panel</a></li>
                    <li><a class="l_button" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <h1>Users</h1>
            <br>
            <div class="ticket_container">
                <div class="ticket_grid">
                <?php
                // Query to fetch booked tickets along with seat numbers
                $query = "
                    SELECT user_id,fullname,username,password FROM user where usertype='user';
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
                                    <label for="user_id">User Id: <?php echo $row['user_id']; ?></label>
                                </div>
                                <br><br>
                                <label for="fullname">Full Name: <?php echo $row['fullname']; ?></label>
                                <br><br>
                                <label for="username">username: <?php echo $row['username']; ?></label>
                                <br><br>
                                <label for="password">Password: <?php echo $row['password']; ?></label>
                                <br><br>
                                <!-- Form to delete the users -->
                                <form method="post" action="deleteuser.php">
                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                    <input type="hidden" name="fullname" value="<?php echo $row['fullname']; ?>">
                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                    <button type="submit" class="cancel_button">Delete User</button>
                                </form>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p style='text-align: center;'>No users found.</p>";
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
