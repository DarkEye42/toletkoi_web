<?php
// Database configuration
session_start();
include('admin/include/db_config.php');

// Check if the user is logged in and is an owner
if (!isset($_SESSION['id']) || !$_SESSION['is_owner']) {
    header("Location: index.php");
    exit();
}

// Get the renter ID from the query string
if (!isset($_GET['renter_id'])) {
    header("Location: owner_dashboard.php");
    exit();
}

$renterID = $_GET['renter_id'];

// Fetch renter details
$renterQuery = "SELECT * FROM users WHERE id = $renterID";
$renterResult = $con->query($renterQuery);
if ($renterResult->num_rows == 0) {
    header("Location: owner_dashboard.php");
    exit();
}
$renterData = $renterResult->fetch_assoc();

// Fetch utility bills for the renter
$billsQuery = "SELECT * FROM utility_bills WHERE renter_id = $renterID";
$billsResult = $con->query($billsQuery);

// Fetch room rent details
$rentQuery = "SELECT * FROM rent_details WHERE renter_id = $renterID";
$rentResult = $con->query($rentQuery);
if ($rentResult->num_rows == 0) {
    //header("Location: owner_dashboard.php");
   // exit();
}
$rentData = $rentResult->fetch_assoc();

// Calculate the monthly total bills
$utilityTotal = 0;
while ($billRow = $billsResult->fetch_assoc()) {
    $utilityTotal += $billRow['amount'];
}

$roomRent = $rentData['room_rent'];
$totalBills = $utilityTotal + $roomRent;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Renter Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <h2>Renter Management</h2>
        <h3>Renter Details</h3>
        <p><strong>Name:</strong> <?php echo $renterData['first_name']; ?></p>
        <p><strong>Email:</strong> <?php echo $renterData['email']; ?></p>
        <!-- Additional renter details can be displayed here -->

        <h3>Monthly Total Bills</h3>
        <p><strong>Utility Bills:</strong> $<?php echo $utilityTotal; ?></p>
        <p><strong>Room Rent:</strong> $<?php echo $roomRent; ?></p>
        <p><strong>Total Bills:</strong> $<?php echo $totalBills; ?></p>
        <!-- Additional billing details can be displayed here -->
    </div>
</body>
</html>