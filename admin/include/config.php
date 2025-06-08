<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// DB Configs (you can switch between localhost and production by commenting/uncommenting)
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "rentalorb");

// define("DB_HOST", "localhost");
// define("DB_USER", "darkeye42_darkeye");
// define("DB_PASS", "@DarkEye-2022!");
// define("DB_NAME", "darkeye42_RentalOrb");

// MySQLi Connection
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// PDO Connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}

$conn = $pdo;

?>