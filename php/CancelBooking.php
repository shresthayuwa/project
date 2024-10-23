<?php
include("connect.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("location:login.php");
    exit(); // Ensure script stops after redirect
}

$username = $_SESSION["username"];

// Check if the required data is set
if (isset($_POST['seat']) && isset($_POST['bus_id']) && isset($_POST['username'])) {
    $seat = $_POST['seat'];
    $bus_id = $_POST['bus_id'];

    // Basic validation (You can extend this based on your requirements)
    if (empty($seat) || empty($bus_id) || $username !== $_POST['username']) {
        header("Location: user.php?error=Invalid request.");
        exit();
    }

    // Query to check if the booking exists
    $checkQuery = "
        SELECT seat, username, bus_id
        FROM booked_seats
        WHERE seat = '$seat' AND username = '$username' AND bus_id = '$bus_id'
    ";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Query to delete the booked seat from booked_seats table
        $deleteQuery = "
            DELETE FROM booked_seats
            WHERE seat = '$seat' AND username = '$username' AND bus_id = '$bus_id'
        ";
        if (mysqli_query($conn, $deleteQuery)) {
            // Successfully deleted
            header("Location: user.php?message=Booking cancelled successfully.");
            exit(); // Ensure script stops after redirect
        } else {
            // Redirect with an error message
            header("Location: user.php?error=Error cancelling booking.");
            exit();
        }
    } else {
        // Redirect with an error message if no booking found
        header("Location: user.php?error=No booking found to cancel.");
        exit();
    }
} else {
    // Redirect with an error message for invalid request
    header("Location: user.php?error=Invalid request.");
    exit();
}
?>
