<?php
include("connect.php");
session_start();

// Ensure bus_id is captured when the ticket is selected
if (isset($_POST['bus_id'])) {
    $_SESSION['bus_id'] = $_POST['bus_id'];
}

// Fetch booked seats from the database
$bookedSeats = [];
$query = "SELECT seat FROM booked_seats WHERE bus_id = " . $_SESSION['bus_id'];
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $bookedSeats[] = $row['seat']; // Store each booked seat in the array
}

$bookingMessage = '';

// Handle seat booking if the form is submitted
if (isset($_POST['submit'])) {
    $selectedSeat = $_POST['left_row'] ?? $_POST['right_row'] ?? null;

    if ($selectedSeat && isset($_SESSION['bus_id'])) {
        // Check if the seat is already booked
        if (!in_array($selectedSeat, $bookedSeats)) {
            // Fetch the price for the selected bus_id
            $priceQuery = "SELECT price FROM ticket WHERE bus_id = " . $_SESSION['bus_id'];
            $priceResult = mysqli_query($conn, $priceQuery);

            if ($priceResult) {
                $priceRow = mysqli_fetch_assoc($priceResult);
                $price = $priceRow['price'] ?? 0; // Default to 0 if no price found

                // Insert selected seat, username, bus_id, and price into the database
                $username = $_SESSION['username'];
                $insertQuery = "INSERT INTO booked_seats (seat, username, bus_id, price) 
                                VALUES ('$selectedSeat', '$username', " . $_SESSION['bus_id'] . ", $price)";
                
                if (mysqli_query($conn, $insertQuery)) {
                    $bookingMessage = "Seat $selectedSeat booked successfully at a price of $" . number_format($price, 2) . ".";
                    // Optionally redirect to a confirmation page or the user panel
                    header("Location: user.php?booking=success"); // Redirect after booking
                    exit();
                } else {
                    $bookingMessage = "Error booking seat: " . mysqli_error($conn);
                }
            } else {
                $bookingMessage = "Error fetching price: " . mysqli_error($conn);
            }
        } else {
            $bookingMessage = "Seat $selectedSeat is already booked.";
        }
    } else {
        $bookingMessage = "Please select a seat or bus.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/seatselect.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Seat Selection</title>
</head>
<body>
    <div class="bus-container">
        <h1>Bus Seat Selection</h1>
        <div class="bus-layout">
            <div class="seat-row">
                <div class="seat" id="seat1">L1</div>
                <div class="seat" id="seat2">L2</div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="seat" id="seat3">R1</div>
                <div class="seat" id="seat4">R2</div>
            </div>
            <div class="seat-row">
                <div class="seat" id="seat5">L3</div>
                <div class="seat" id="seat6">L4</div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="seat" id="seat7">R3</div>
                <div class="seat" id="seat8">R4</div>
            </div>
            <div class="seat-row">
                <div class="seat" id="seat9">L5</div>
                <div class="seat" id="seat10">L6</div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="seat" id="seat11">R5</div>
                <div class="seat" id="seat12">R6</div>
            </div>
            <div class="seat-row">
                <div class="seat" id="seat13">L7</div>
                <div class="seat" id="seat14">L8</div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="seat" id="seat15">R7</div>
                <div class="seat" id="seat16">R8</div>
            </div>
        </div>

        <!-- Seat selection form -->
        <form method="post" class="formbook">
            <h3>Select one seat at a time</h3>
            <br>
            <div class="main_container">
                <div class="left-section">
                    <select name="left_row" id="lr">
                        <option value="" disabled selected hidden>Left Row&nbsp;</option>
                        <?php
                        $leftSeats = ['L1', 'L2', 'L3', 'L4', 'L5', 'L6', 'L7', 'L8'];
                        $availableLeftSeats = array_filter($leftSeats, fn($seat) => !in_array($seat, $bookedSeats));

                        foreach ($availableLeftSeats as $seat) {
                            echo "<option value='$seat'>$seat</option>";
                        }
                        if (empty($availableLeftSeats)) {
                            echo "<option value='' disabled>No seats available</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="right-section">
                    <select name="right_row" id="rr">
                        <option value="" disabled selected hidden>Right Row</option>
                        <?php
                        $rightSeats = ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8'];
                        $availableRightSeats = array_filter($rightSeats, fn($seat) => !in_array($seat, $bookedSeats));

                        foreach ($availableRightSeats as $seat) {
                            echo "<option value='$seat'>$seat</option>";
                        }
                        if (empty($availableRightSeats)) {
                            echo "<option value='' disabled>No seats available</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="button-container">
                <button type="submit" name="submit" class="buttons">Submit</button>
                <button type="button" onclick="document.location='user.php'" class="buttons">Head back</button>
            </div>
        </form>

        <?php
        // Show booking message if set
        if ($bookingMessage) {
            echo "<div class='message'>$bookingMessage</div>";
        }

        // Show a message if no seats are available in both rows
        if (empty($availableLeftSeats) && empty($availableRightSeats)) {
            echo "<div class='message'>No seats available in both rows.</div>";
        }
        ?>
    </div>
</body>
</html>
