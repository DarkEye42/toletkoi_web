<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "You are not logged in.";
    exit();
}

$action = $_POST['action'];

if ($action == 'send') {
    // Generate a new token
    $token = generateToken();

    // Insert the token into the verification table
    $userId = $_SESSION['id'];
    $query = "INSERT INTO verification (user_id, token) VALUES ($userId, '$token')";
    mysqli_query($con, $query);

    // Send the verification email
    sendEmail('verify', $_SESSION['email'], $token);

    echo "Verification email sent.";
} else if ($action == 'resend') {
    // Generate a new token
    $token = generateToken();

    // Update the verification table with the new token
    $userId = $_SESSION['id'];
    $query = "UPDATE verification SET token = '$token' WHERE user_id = $userId";
    mysqli_query($con, $query);

    // Send the verification email
    sendEmail('verify', $_SESSION['email'], $token);

    echo "Verification email re-sent.";
} else {
    echo "Invalid action.";
}
?>