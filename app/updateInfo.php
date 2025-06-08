<?php


    // DB Configs
    define('DB_HOST', 'localhost');
    define('DB_USER', 'darkeye42_darkeye');
    define('DB_PASS', '@DarkEye-2021!');
    define('DB_NAME', 'darkeye42_RentalOrb');
    

    if (isset($_POST['email']) && isset($_POST['password'])){
        
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $conn->set_charset("utf8");

        require_once "validate.php";
        $email_var = validate($_POST['email']);
        $password_var = validate($_POST['password']);
        $md5Pass = md5($password_var);


        $firstName_var = validate($_POST['put_firstName']);
        $lastName_var = validate($_POST['put_lastName']);
        $profession_var = validate($_POST['put_profession']);
        $aboutMe_var = validate($_POST['put_about']);
        $address_var = validate($_POST['put_address']);
        $ps_var = validate($_POST['put_ps']);
        $district_var = validate($_POST['put_district']);
        $division_var = validate($_POST['put_division']);
        $zipCode_var = validate($_POST['put_zipCode']);
        $dob_var = validate($_POST['put_dob']);
        $gander_var = validate($_POST['put_gander']);
        $lat_var = validate($_POST['put_lat']);
        $long_var = validate($_POST['put_long']);

        $update = "update users set first_name='".$firstName_var."', last_name='".$lastName_var."',
        profession='".$profession_var."', birthDate='".$dob_var."', gander='".$gander_var."', aboutMe='".$aboutMe_var."',
        village='".$address_var."', policeStation='".$ps_var."', district='".$district_var."',
        division='".$division_var."', zipCode='".$zipCode_var."', latitude='".$lat_var."',
        longitude='".$long_var."', isUpdated='1' where email like '".$email_var."'
        and password like '".$md5Pass."'";

        /*$update = "update users set first_name ='".$firstName_var."', last_name ='".$lastName_var."',
        profession='".$profession_var."', birthDate='".$dob_var."', aboutMe='".$aboutMe_var."'
        where email like '".$email_var."' and password like '".$md5Pass."'";*/
        
        $response = mysqli_query($conn, $update);
        if ($response === TRUE){
            echo "success";
        } else {
            echo "failure";
        }
                
        $conn->close();
    } else {
        echo "Nothing to show!";
    }

?>
