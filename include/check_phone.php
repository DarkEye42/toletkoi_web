<?php
// Database connection
require('../admin/include/db_config.php');

if ($con->connect_error) {
    die('Connection failed: ' . $con->connect_error);
}

// Check if phone number exists
$phone = $_POST['phone'];
$query = "SELECT * FROM users WHERE phone = '$phone'";
$result = $con->query($query);

if ($result->num_rows > 0) {
    echo '<span style="color: red;">Phone number already exists!</span>';
} else {
    echo '<span style="color: green;">Phone number is available.</span>';
}

$con->close();
?>
