<?php
// Database configuration
session_start();
include('admin/include/db_config.php');

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    exit('<i class="bi bi-circle-fill text-denger" style="font-size: x-small"></i>');
}

$userID = $_SESSION['id'];

// Update the user's last_seen field in the database
$updateQuery = "UPDATE users SET last_seen = NOW() WHERE id = $userID";
$con->query($updateQuery);

// Check the user's online status
$checkQuery = "SELECT last_seen FROM users WHERE id = $userID";
$result = $con->query($checkQuery);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastSeen = strtotime($row['last_seen']);
    $currentTime = time();

    // Check if the user is online or offline
    if ($currentTime - $lastSeen <= 5) { // Consider user online if last seen within the last 5 seconds
        exit('<i class="bi bi-circle-fill text-success" style="font-size: x-small"></i>');
    } else {
        exit('<i class="bi bi-circle-fill text-denger" style="font-size: x-small"></i>');
    }
} else {
    exit('<i class="bi bi-circle-fill text-denger" style="font-size: x-small"></i>');
}
?>