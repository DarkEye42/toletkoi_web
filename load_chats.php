<?php
session_start();
include('admin/include/db_config.php');

// Fetch chat history between sender and receiver
$senderID = $_SESSION['id'];
$receiverID = $_POST['receiver_id'];

$chatQuery = "SELECT c.message, u.first_name, ua.online_status, ua.typing_status
    FROM chats c
    INNER JOIN users u ON u.id = c.sender_id
    INNER JOIN user_activity ua ON ua.user_id = c.sender_id
    WHERE (c.sender_id = $senderID AND c.receiver_id = $receiverID) OR (c.sender_id = $receiverID AND c.receiver_id = $senderID)
    ORDER BY c.sent_at ASC";

$chatResult = $con->query($chatQuery);
if (!$chatResult) {
    // Display the database error
    die("Query error: " . $con->error);
}

if ($chatResult->num_rows > 0) {
    while ($row = $chatResult->fetch_assoc()) {
        $message = $row['message'];
        $username = $row['first_name'];
        $onlineStatus = $row['online_status'];
        $typingStatus = $row['typing_status'];

        echo '<p><strong>' . $username . '</strong>: ' . $message . '</p>';
        echo '<p>Online Status: ' . $onlineStatus . '</p>';
        echo '<p>Typing Status: ' . $typingStatus . '</p>';
    }
} else {
    echo "No chat history found.";
}

// Close database connection
$con->close();
?>