<?php
require('../admin/include/db_config.php');

if ($con->connect_error) {
    die('Connection failed: ' . $con->connect_error);
}

// Check if email exists
$email = $_POST['email'];
$query = "SELECT * FROM users WHERE email = '$email'";
$result = $con->query($query);

if ($result->num_rows > 0) {
    echo '<span style="color: red;">Email already exists!</span>';
} else {
    echo '<span style="color: green;">Email is available.</span>';
}

$con->close();
?>