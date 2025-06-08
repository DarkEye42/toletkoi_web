<?php
// DB Configs
include "config.php";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('Unable to connect with database: ' . $conn->connect_error);
}

require_once "validate.php";

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2)
{
    $theta = $longitude1 - $longitude2;
    $distance_var = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) +
        (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))));
    $distance_1 = acos($distance_var);
    $distance_2 = rad2deg($distance_1);
    $distance_3 = $distance_2 * 60 * 1.1515;

    $distance = $distance_3 * 1.609344;

    return round($distance, 2);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === "postData" && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['postId'])) {

        $email_var = validate($_POST['email']);
        $postId_var = validate($_POST['postId']);
        $password_var = validate($_POST['password']);
        $md5Pass = md5($password_var);

        $stmt = $conn->prepare("SELECT `id`, `uniqueId`, `post_owner`, `title`, `description`, `coverImage`, `coverImage2nd`,
                    `coverImage3rd`, `renter_type`, `takeOver`, `street`, `area`, `policeStation`, `district`, `facilities`,
                    `cost`, `building_type`, `contact`, `date`, `latitude`, `longitude` FROM rentalposts WHERE `uniqueId` = ?");
        $stmt->bind_param("s", $postId_var);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $adsData = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($adsData);
        } else {
            echo json_encode([]);
        }
    } else {
        echo json_encode([]);
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === "myAds" && isset($_GET['email']) && isset($_GET['password'])) {

        $email_var = validate($_GET['email']);
        $password_var = validate($_GET['password']);
        $md5Pass = md5($password_var);

        $stmt = $conn->prepare("SELECT `id` FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email_var, $md5Pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['id'];

            $stmt = $conn->prepare("SELECT `id`, `uniqueId`, `post_owner`, `title`, `description`, `coverImage`, `coverImage2nd`,
                                `coverImage3rd`, `renter_type`, `allowedRenter`, `takeOver`, `street`, `area`, `policeStation`, `district`,
                                `cost`, `building_type`, `contact`, `date`, `latitude`, `longitude`, `electricity`, `water`, `gas`, `internet`, `ac`, `elevator`, `rooms`
                                FROM rentalposts WHERE `post_owner` = ? ORDER BY `date` DESC");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $adsData = $result->fetch_all(MYSQLI_ASSOC);
                echo json_encode($adsData);
            } else {
                echo json_encode([]);
            }
        } else {
            echo json_encode([]);
        }
    } else {
        $stmt = $conn->prepare("SELECT `id`, `uniqueId`, `post_owner`, `title`, `description`, `coverImage`, `coverImage2nd`,
                    `coverImage3rd`, `renter_type`, `allowedRenter`, `takeOver`, `street`, `area`, `policeStation`, `district`,
                    `cost`, `building_type`, `contact`, `date`, `latitude`, `longitude`, `electricity`, `water`, `gas`, `internet`, `ac`, `elevator`, `rooms`
                    FROM rentalposts ORDER BY `date` DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $adsData = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($adsData);
        } else {
            echo json_encode([]);
        }
    }
}

$conn->close();
?>