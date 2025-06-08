<?php

    include "config.php";

    function addPost(
        $email_data,
        $password_data,
        $title_data,
        $description_data,
        $renter_type_data,
        $takeOver_data,
        $street_data,
        $area_data,
        $ps_data,
        $district_data,
        $facilities_data,
        $cost_data,
        $building_type_data,
        $contact_data,
        $postTime_data,
        $lat_data,
        $long_data){

        if(!empty($email_data) && !empty($password_data)){
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if ($conn){
                require_once "validate.php";
                $email = validate($email_data);
                $password_var = validate($password_data);
                $md5Pass = md5($password_var);

                // Data Hookups
                $title_var = validate($title_data);
                $description_var = validate($description_data);
                $renter_type_var = validate($renter_type_data);
                $takeOver_var = validate($takeOver_data);
                $street_var = validate($street_data);
                $area_var = validate($area_data);
                $ps_var = validate($ps_data);
                $district_var = validate($district_data);
                $facilities_var = validate($facilities_data);
                $cost_var = validate($cost_data);
                $building_type_var = validate($building_type_data);
                $contact_var = validate($contact_data);
                $date_var = validate($postTime_data);
                $lat_var = validate($lat_data);
                $long_var = validate($long_data);
                $data = "failure";

                $log_sql = "select * from users where email like '$email'";
                    $log_result = $conn->query($log_sql);
                    if (mysqli_num_rows($log_result) > 0){
                        $sql = "select id from users where email like '$email'
                        and password like '$md5Pass'";
                        $result = $conn->query($sql);
                        if (mysqli_num_rows($result) > 0){

                            while($row = $result->fetch_assoc()) {
                                if($row['id'] != 0){
                                    
                                    $sql = "insert into rentalPosts (post_owner, title, description, renter_type,
                                    takeOver, street, area, policeStation, district, facilities, cost, building_type,
                                    contact, date, latitude, longitude)
                                    values (".$row['id'].", ".$title_var.", ".$description_var.", ".$renter_type_var.", ".$takeOver_var.",
                                    ".$street_var.", ".$area_var.", ".$ps_var.", ".$district_var.", ".$facilities_var.", ".$cost_var.",
                                    ".$building_type_var.", ".$contact_var.", ".$date_var.", ".$lat_var.", ".$long_var.")";

                                    if ($conn->query($sql) === TRUE){
                                        $data = "success";
                                    }
                                } else {
                                    $data = "error";
                                }
                            }
                        }
                    }
                    $conn->close();
            }

        } else {
            $data = "null_data";
        }

            return $data;
        }

?>