<?php
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "User not logged in.";
    exit();
}

// Check if the user is already verified
$userId = $_SESSION["id"];
$query = "SELECT is_email_verified FROM users WHERE id = $userId";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$isVerified = $row['is_email_verified'];

if ($isVerified) {
    echo "Email already verified.";
} else {
    // Check if a verification token already exists
    $query = "SELECT token, created_at FROM verification WHERE user_id = $userId ORDER BY created_at DESC LIMIT 1";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 0) {
        echo "Verification email not sent.";
    } else {
        $row = mysqli_fetch_assoc($result);
        $token = $row['token'];
        $createdAt = strtotime($row['created_at']);
        $currentTimestamp = strtotime(date('Y-m-d H:i:s'));
        $timeDiff = $currentTimestamp - $createdAt;

        if ($timeDiff >= (2 * 60 * 60)) {
            echo "Verification link expired.";
        } else {
            echo "Verification email sent.";
        }
    }
}
?>