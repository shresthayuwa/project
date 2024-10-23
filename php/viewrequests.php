<?php
include("connect.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("location:login.php");
    exit();
}
$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Requests</title>
    <link rel="stylesheet" href="../css/view.css">
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
            <h1>View Requests</h1>
        </div>
        <div class="nav2">
            <ul>
                <li><a href="admin.php">Admin Panel</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container">
        <table>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php
            // Query to fetch all requests
            $query = "SELECT id, username, img FROM payment_img";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>
                            <a href='../Pictures/payments/" . $row["img"] . "' target='_blank'>
                                <img src='../Pictures/payments/" . $row["img"] . "' width=200 alt='" . $row['img'] . "'>
                            </a>
                          </td>";
                    echo "<td><a href='#'>Approve</a> | <a href='#'>Deny</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No requests found</td></tr>";
            }
            ?>
        </table>
    </div>
    <div class="clear"></div>
    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2024, All Rights Reserved,<br>Designed by: <b>BusEase</b></p>
    </div>
</div>
</body>
</html>
