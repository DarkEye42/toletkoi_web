<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
    // DB Configs
    include "config.php";

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die('Unable to connect with database: ' . $conn->connect_error);
    }

    require_once "validate.php";

    $email_var = validate($_POST['email']);
    $password_var = validate($_POST['password']);
    $md5Pass = md5($password_var);

    if (isset($_POST['postOwner']) && $_POST['postOwner'] != null) {
        $id_var = validate($_POST['postOwner']);
        $stmt = $conn->prepare("SELECT id, first_name, last_name, profession, email, phone,
            nidNumber, birthDate, aboutMe, avatar, joinDate, village, policeStation, district, division, zipCode,
            latitude, longitude, isUpdated, isRenter, isVerified FROM users WHERE id = ?");
        $stmt->bind_param("i", $id_var);
    } else {
        $stmt = $conn->prepare("SELECT id, first_name, last_name, profession, email, phone,
            nidNumber, birthDate, aboutMe, avatar, joinDate, village, policeStation, district, division, zipCode,
            latitude, longitude, isUpdated, isRenter, isVerified FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email_var, $md5Pass);
    }

    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->execute();

    if ($stmt->error) {
        die('Execute failed: ' . $stmt->error);
    }

    $stmt->bind_result($id, $first_name, $last_name, $profession, $email, $phone,
        $nidNumber, $birthDate, $aboutMe, $avatar, $joinDate, $village, $policeStation, $district, $division, $zipCode,
        $latitude, $longitude, $isUpdated, $isRenter, $isVerified);

    $userData = array();

    while ($stmt->fetch()) {
        $temp = array();
        $temp['id'] = $id;
        $temp['first_name'] = $first_name;
        $temp['last_name'] = $last_name;
        $temp['profession'] = $profession;
        $temp['email'] = $email;
        $temp['phone'] = $phone;
        $temp['nidNumber'] = $nidNumber;
        $temp['birthDate'] = $birthDate;
        $temp['aboutMe'] = $aboutMe;
        $temp['avatar'] = $avatar;
        $temp['joinDate'] = $joinDate;
        $temp['village'] = $village;
        $temp['policeStation'] = $policeStation;
        $temp['district'] = $district;
        $temp['division'] = $division;
        $temp['zipCode'] = $zipCode;
        $temp['latitude'] = $latitude;
        $temp['longitude'] = $longitude;
        $temp['isUpdated'] = $isUpdated;
        $temp['isRenter'] = $isRenter;
        $temp['isVerified'] = $isVerified;

        array_push($userData, $temp);
    }

    $stmt->close();
    $conn->close();

    echo json_encode($userData);
}
?>