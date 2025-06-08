<?php
    require('include/essentials.php');
    require('include/db_config.php');
    if(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true){
        redirect('dashboard.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <?php require('include/commonLinks.php') ?>
    <style>
        div.login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="POST">
            <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <label class="form-label">Admin ID</label>
                    <input type="text" name="adminID" class="form-control shadow-none" placeholder="Admin ID" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control shadow-none" placeholder="Password" required>
                </div>
                <button type="submit" name="login" class="btn btn-inverse-primary btn-fw">LOGIN</button>
            </div>
        </form>
    </div>
    <?php
        // if (isset($_POST["login"])){
        //     $from_data = filteration($_POST);
        //     $post_email = $from_data["email"];
        //     $post_pass = md5($from_data["password"]);
        //     $res = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$post_email' AND `password`='$post_pass'");
        //     if (mysqli_num_rows($res)===1){
        //         $row = mysqli_fetch_assoc($res);
        //         $_SESSION["userLogin"] = true;
        //         $_SESSION["email"] = $row["email"];
        //         $_SESSION["id"] = $row["id"];
        //         redirect("index.php");

        //         alert("success", "Welcome back!");
        //     } else {
        //         alert("error", "Login failed - Invalid Credentials!");
        //     }
        // }

        if (isset($_POST['login'])){
            $from_data = filteration($_POST);
            $post_email = $from_data["adminID"];
            $post_pass = md5($from_data["password"]);
            
            $res = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$post_email' AND `password`='$post_pass' AND `adminPower`>'0'");

            if (mysqli_num_rows($res)===1){
                $row = mysqli_fetch_assoc($res);
                $_SESSION['adminLogin'] = true;
                $_SESSION['adminID'] = $row['adminId'];
                $_SESSION['id'] = $row['id'];
                redirect('dashboard.php');

                alert('success', 'Welcome to Admin Panel!');
            } else {
                alert('error', 'Login failed - Invalid Credentials!');
            }
        }
        if(isset($_GET['error'])){
            if ($_GET['error']=="401"){
                alert('error', '401 - Unauthorized attempt to view this page.');
            }
        }
    ?>

<?php require('../include/scripts.php') ?>
<?php require('include/commonScripts.php') ?>
</body>
</html>