<?php

include "config.php";
    

    if (isset($_POST['email']) && isset($_POST['password'])){
        require_once "api_functions.php";

        signUp($_POST['email'], $_POST['password'], $_POST['joinDate']);

    } else {
        echo "Nothing to show!";
    }

?>
