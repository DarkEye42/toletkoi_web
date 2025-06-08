<?php

    include "config.php";

    if (isset($_POST['email']) && isset($_POST['password'])){
        
        $conn = mysqli_connect($server, $username, $password, $database);

        require_once "validate.php";
        $email = validate($_POST['email']);
        $password = validate($_POST['password']);
        $md5Pass = md5($password);

        if($conn){
            $log_sql = "select * from users where email like '$email'";
                $log_result = $conn->query($log_sql);
                if (mysqli_num_rows($log_result) > 0){
                    $sql = "select * from users where email like '$email'
                    and password like '$md5Pass'";
                    $result = $conn->query($sql);
                    if (mysqli_num_rows($result) > 0){
                        echo "success";
                    } else {
                        echo "failure";
                    }
                } else {
                    echo "email_not_exist";
                }
        $conn->close(); 
        }

    } else {
        echo "Nothing to show!";
    }

?>
