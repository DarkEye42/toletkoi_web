<?php

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "User not logged in.";
    exit();
}

// Check if a verification token already exists
$userId = $_SESSION['id'];
$query = "SELECT token, created_at FROM verification WHERE user_id = $userId ORDER BY created_at DESC LIMIT 1";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) == 0) {
    // Generate a new token
    $token = generateToken();

    // Insert the token into the verification table
    $query = "INSERT INTO verification (user_id, token) VALUES ($userId, '$token')";
    mysqli_query($con, $query);

    // Send the verification email
    sendMail('verify', $_SESSION['email'], $token);

    echo '<button class="btn btn-primary" id="verify-email-send-button">Send Email</button>';
} else {
    $row = mysqli_fetch_assoc($result);
    $token = $row['token'];
    $createdAt = strtotime($row['created_at']);
    $currentTimestamp = strtotime(date('Y-m-d H:i:s'));
    $timeDiff = $currentTimestamp - $createdAt;

    if ($timeDiff >= (5 * 60)) {
        echo '<button class="btn btn-primary" id="verify-email-resend-button"">Re-Send Email</button>';
    } else {
        $remainingTime = (5 * 60) - $timeDiff;
        $remainingMinutes = floor($remainingTime / 60);
        echo "Please wait " . $remainingMinutes . " minute to re-send the email.";
    }
}

mysqli_close($con);
?>
