<?php
    include("connect.php");
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:login.php");
    }

    // Handle image upload
    if(isset($_POST["submit"])){
        $username = $_SESSION["username"];

        // Check if file was uploaded
        if(isset($_FILES["payment_image"]) && $_FILES["payment_image"]["error"] == 0){
            $fileName = $_FILES["payment_image"]["name"];
            $fileSize = $_FILES["payment_image"]["size"];
            $tmpName = $_FILES["payment_image"]["tmp_name"];

            // Validating image extension
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($imageExtension, $validImageExtension)) {
                echo "<script> alert('Invalid Image Extension. Please upload a file with .jpg, .jpeg, or .png extension.'); </script>";
            } else if($fileSize > 1000000){
                echo "<script> alert('Image Size Is Too Large. Max size allowed is 1MB.'); </script>";
            } else {
                // Rename the image with a unique ID to avoid overwriting
                $newImageName = uniqid() . '.' . $imageExtension;

                // Move the uploaded file to the folder
                move_uploaded_file($tmpName, '../Pictures/payments/' . $newImageName);

                // Insert the image name into the payment_img table with the username
                $query = "INSERT INTO payment_img (username, img) VALUES ('$username', '$newImageName')";
                if (mysqli_query($conn, $query)) {
                    echo "<script>
                        alert('Successfully Added');
                        document.location.href = 'user.php';
                    </script>";
                } else {
                    echo "<script> alert('Error in Uploading Image'); </script>";
                }
            }
        } else {
            // Display this error only if no file is uploaded
            echo "<script> alert('Please select an image to upload.'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/checkout.css">
    <title>Check Out Page</title>
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
                <h1>Checkout Page</h1>
            </div>
            <div class="nav2">
                <ul>
                    <li><a href="user.php">User Panel</a></li>
                    <li><a href="ViewBookedTickets.php">View Booked Tickets</a></li>
                    <li><a class="logout_button" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <p>Note:</p>
            <ul>
                <li>Please write your full name and booked seat as remarks while paying.</li>
                <li>Payment once made cannot be refunded. So please make payments carefully.</li>
            </ul>

            <img src="../Pictures/payment_qr.jpg" alt="Payment QR Code">

            <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <input type="file" name="payment_image" id="image" accept=".jpg, .jpeg, .png" onchange="previewFile()">
                <img id="preview" alt="Preview of uploaded file">
                <div class="button-container">
                    <button type="submit" name="submit">Check Out</button>
                    <button type="button" onclick="location.href='user.php';">Back to User Panel</button>
                </div>
            </form>

        </div>

        <div class="clear"></div>

        <!-- Footer Section -->
        <div class="footer">
            <p>&copy; 2024, All Rights Reserved,<br>Designed by: <b>BusEase</b></p>
        </div>
        <!-- JavaScript to handle form validation and image preview -->
        <script>
            function previewFile() {
                const file = document.querySelector('#image').files[0];
                const preview = document.querySelector('#preview');
                
                const reader = new FileReader();
                reader.addEventListener('load', function () {
                    // Convert file to base64 string and display as image preview
                    preview.src = reader.result;
                    preview.style.display = 'block';  // Show the image
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
                }
            }

            function validateForm() {
                const fileInput = document.querySelector('#image').files.length;
                if (fileInput === 0) {
                    alert("Please select an image before submitting.");
                    return false;
                }
                return true;
            }
        </script>

    </div>
</body>

</html>
