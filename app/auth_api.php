<?php

    include "api_functions.php";

    if($_GET['action'] == null){
        header("Location: index.html");
    }
    
    // Calling login function
    if($_GET['action'] == "signIn"){
        echo signIn($_POST['email'], $_POST['password']);
    }

    // Calling registration function
    if($_GET['action'] == "signUp"){
        echo signUp($_POST['email'], $_POST['password'], $_POST['joinDate']);
    }

?>