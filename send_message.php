<?php
session_start();
include('admin/include/db_config.php');

// Get sender ID from session
$senderID = $_SESSION['id'];

// Get receiver ID from POST data
$receiverID = $_POST['receiver_id'];

// Get message from POST data
$message = $_POST['message'];

// Insert message into the chats table
$insertQuery = "INSERT INTO chats (sender_id, receiver_id, message) VALUES ($senderID, $receiverID, '$message')";

if ($con->query($insertQuery) === TRUE) {
    echo "Message sent successfully.";
} else {
    echo "Error sending message: " . $con->error;
}

// Close database connection
$con->close();
?>