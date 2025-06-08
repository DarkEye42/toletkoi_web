<?php
    // DB Configs
    define('DB_HOST', 'localhost');
    define('DB_USER', 'darkeye42_darkeye');
    define('DB_PASS', '@DarkEye-2021!');
    define('DB_NAME', 'darkeye42_RentalOrb');

    /*if($_GET['action'] == null){
        // If No Action Found
        header("Location: index.html");
    }*/

    // AddPost Function
        if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['createAds'])){
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if(isset($_POST['lat']) && isset($_POST['long'])){

                if ($conn){
                    require_once "validate.php";
                    $email_var = validate($_POST['email']);
                    $password_var = validate($_POST['password']);
                    $md5Pass = md5($password_var);

                    // Data Hookups
                    $title_var = validate($_POST['title']);
                    $description_var = validate($_POST['description']);
                    $renter_type_var = validate($_POST['renter_type']);
                    $takeOver_var = validate($_POST['takeOver']);
                    $street_var = validate($_POST['street']);
                    $area_var = validate($_POST['area']);
                    $ps_var = validate($_POST['ps']);
                    $district_var = validate($_POST['district']);
                    $bedRooms_var = validate($_POST['bedRooms']);
                    $cost_var = validate($_POST['cost']);
                    $building_type_var = validate($_POST['building_type']);
                    $contact_var = validate($_POST['contact']);
                    $date_var = validate($_POST['postTime']);
                    $lat_var = validate($_POST['lat']);
                    $long_var = validate($_POST['long']);

                    $gender_var = validate($_POST['gender']);
                    $electricity_var = validate($_POST['electricity']);
                    $water_var = validate($_POST['water']);
                    $gas_var = validate($_POST['gas']);
                    $internet_var = validate($_POST['internet']);
                    $ac_var = validate($_POST['ac']);
                    $elevator_var = validate($_POST['elevator']);

                    // Image Data Hookups
                    $image_1 = $_POST['upload_1stImage'];
                    $image_2 = $_POST['upload_2ndImage'];
                    $image_3 = $_POST['upload_3rdImage'];
                    $target_dir = "images/post";

                    $sql_id = "select id from users where email like '$email_var'
                    and password like '$md5Pass'";
                    $result = $conn->query($sql_id);
                    if (mysqli_num_rows($result) > 0){

                        while($row = $result->fetch_assoc()) {
                            if($row['id'] > 0){

                                $imageName_1 = rand()."_".time().".jpeg";
                                $image_path_1 = $target_dir."/".$imageName_1;

                                if($_POST['upload_2ndImage'] != "empty"){
                                    $imageName_2 = rand()."_".time().".jpeg";
                                    $image_path_2 = $target_dir."/".$imageName_2;
                                } else {
                                    $imageName_2 = null;
                                    $image_path_2 = null;
                                }

                                if($_POST['upload_3rdImage'] != "empty"){
                                    $imageName_3 = rand()."_".time().".jpeg";
                                    $image_path_3 = $target_dir."/".$imageName_3;
                                } else {
                                    $imageName_3 = null;
                                    $image_path_3 = null;
                                }

                                file_put_contents($image_path_1, base64_decode($image_1));
                                if($_POST['upload_2ndImage'] != "empty"){
                                    file_put_contents($image_path_2, base64_decode($image_2));
                                }

                                if($_POST['upload_3rdImage'] != "empty"){
                                    file_put_contents($image_path_3, base64_decode($image_3));
                                }
                                
                                $sql_insert = "insert into rentalPosts (post_owner, title, description, coverImage, coverImage2nd, coverImage3rd,
                                renter_type, allowedRenter, takeOver, street, area, policeStation, district, cost, building_type, contact, date,
                                latitude, longitude, electricity, water, gas, internet, ac, elevator, rooms)
                                values ('".$row['id']."', '".$title_var."', '".$description_var."', '".$image_path_1."', '".$image_path_2."', '".$image_path_3."', '".$renter_type_var."', '".$gender_var."',
                                '".$takeOver_var."', '".$street_var."', '".$area_var."', '".$ps_var."', '".$district_var."', '".$cost_var."', '".$building_type_var."',
                                '".$contact_var."', '".$date_var."', '".$lat_var."', '".$long_var."', '".$electricity_var."', '".$water_var."', '".$gas_var."', '".$internet_var."',
                                '".$ac_var."',  '".$elevator_var."',  '".$bedRooms_var."')";

                                if ($conn->query($sql_insert) === TRUE){
                                    echo "success";
                                } else {
                                    echo "failure";
                                }
                            } else {
                                echo "error";
                            }
                        }
                    }
                    $conn->close();
                }
            } else {
                echo "wrongAddress";
            }

        } else {
            echo "null_data";
        }
?>