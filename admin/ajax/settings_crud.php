<?php
    require('../include/essentials.php');
    require('../include/db_config.php');
    adminLogin();

    if(isset($_POST['getData'])){
        $sql = mysqli_query($con, "SELECT * FROM `sitedata` WHERE `id`=1");
        $data = mysqli_fetch_assoc($sql);
        $json_data = json_encode($data);
        echo $json_data;
    }

    if(isset($_POST['upd_general'])){
        $form_data = filteration($_POST) ;
        $sql = "UPDATE `sitedata` SET `siteTitle`= '".$form_data['siteTitle']."', `siteAbout`= '".$form_data['siteAbout']."' WHERE `id`=1";

        if(mysqli_query($con, $sql)){
            echo mysqli_affected_rows($con);
        }

        mysqli_close($con);
    }

    if(isset($_POST['upd_maintenance'])){
        $form_data = ($_POST['upd_maintenance']==0) ? 1 : 0;
        $sql = mysqli_query($con, "UPDATE `sitedata` SET `isMaintenance`= $form_data WHERE `id`=1");
        echo $sql;
    }

    if(isset($_POST['getContacts'])){
        $data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `sitedata` WHERE `id`=1"));
        $json_data = json_encode($data);
        echo $json_data;
    }

    if(isset($_POST['upd_contacts'])){
        $form_data = filteration($_POST);

        $sql = "UPDATE `sitedata` SET `address`='".$form_data['address']."',`gmap`='".$form_data['gmap']."',`phn1`='".$form_data['phn_1']."',`phn2`='".$form_data['phn_2']."',`email`='".$form_data['email']."',
                `fb`='".$form_data['fb']."',`tw`='".$form_data['tw']."',`yt`='".$form_data['yt']."',`iframe`='".$form_data['iframe']."' WHERE 1";
        if(mysqli_query($con, $sql)){
            echo mysqli_affected_rows($con);
        }
    }

    if(isset($_POST['create_post'])){
        $form_data = filteration($_POST);
        $takeOver_Time = strtotime($form_data['rentDate']) * 1000;

        $sql = "INSERT INTO `rentalposts`(`post_owner`, `title`, `description`, `renter_type`,
        `allowedRenter`, `takeOver`, `street`, `area`, `policeStation`, `district`, `cost`, `building_type`, `contact`, `date`,
        `electricity`, `water`, `gas`, `internet`, `ac`, `elevator`, `rooms`)
        VALUES ('".$_SESSION['id']."', '".$form_data['title_input']."', '".$form_data['description_input']."', '".$form_data['renterType_input']."', '".$form_data['apply_input']."', '".$takeOver_Time."',
        '".$form_data['street_input']."', '".$form_data['area_input']."', '".$form_data['ps_input']."', '".$form_data['district_input']."', '".$form_data['cost_input']."', '".$form_data['building_input']."', '".$form_data['contact_input']."',
        '".round(microtime(true) * 1000)."', '".$form_data['electricity_input']."', '".$form_data['water_input']."', '".$form_data['gas_input']."', '".$form_data['internet_input']."', '".$form_data['ac_input']."',
        '".$form_data['elevator_input']."', '".$form_data['bedroom_input']."')";
        
        if(mysqli_query($con, $sql)){
            echo mysqli_affected_rows($con);
        }
    }
?>