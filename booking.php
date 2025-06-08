<?php
// Database configuration
session_start();
include('admin/include/db_config.php');
include('admin/include/essentials.php');

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Check if the ad_id is provided
if (!isset($_GET['ads'])) {
    header("Location: index.php");
    exit();
}

$adID = $_GET['ads'];
$renterID = $_SESSION['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input fields
    $start_date = $_POST['start_date'];
    // Additional validation and sanitization can be done here

    // Insert the rental request into the database
    $insertQuery = "INSERT INTO rental_requests (ad_id, renter_id, start_date, status)
        VALUES ($adID, $renterID, '$start_date', 'pending')";
    $insertResult = $con->query($insertQuery);

    if (!$insertResult) {
        // Display the database error
        die("Query error: " . $con->error);
    }
    // Redirect to the ads page or any other page you desire
    header("Location: adsDetails.php?ads=$adID");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Rental Request</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <h2>Submit Rental Request</h2>
        <form action="" method="POST">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" required>
            <br><br>
            <!-- Additional input fields for other details of the rental request can be added here -->
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>