<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ToletKoi</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <?php include('include/commonLinks.php');?>
</head>

    <?php
    $version = phpversion();
    echo 'Current PHP version: ' . $version;
        require("admin/include/db_config.php");
        require("admin/include/essentials.php");
        if (isset($_POST["login"])){
            $from_data = filteration($_POST);
            $post_email = $from_data["email"];
            $post_phone = isset($_POST['phone']) ? $from_data["phone"] : null;
            $post_pass = md5($from_data["password"]);
            // if(isset($_POST['phone']) && $_POST['phone'] != null){
            //     $res = mysqli_query($con, "SELECT * FROM `users` WHERE `phone`='$post_phone' AND `password`='$post_pass'");
            // } else {
            //     $res = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$post_email' AND `password`='$post_pass'");
            // }
            if(empty($post_email) || empty($post_pass)){
                alert('error', 'Please don\'t try to edit the page source in the browser inspect section. Otherwise, you will be banned.');
            } else {
                // Prepare and execute the SQL query
                $stmt = $pdo->prepare("SELECT * FROM `users` WHERE email = :email AND `password` = :pass");
                $stmt->bindParam(':email', $post_email);
                $stmt->bindParam(':pass', $post_pass);
                $stmt->execute();
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() ===1){
                    if($row['is_email_verified'] > 0){
                        $_SESSION["userLogin"] = true;
                        $_SESSION["email"] = $row["email"];
                        $_SESSION["id"] = $row["id"];

                        if ($row["is_owner"]==true) {
                            $_SESSION["is_owner"] = true;
                        }

                        if($row['isUpdated'] != 1){
                            $_SESSION["updateInfo"] = false;
                            redirect("update-info.php");
                        } else {
                            $_SESSION["welcome"] = true;
                            redirect("index.php");
                        }
                    } else {
                        $_SESSION["verify"] = 'incomplete';
                        redirect("index.php");
                    }
                    
                } else {
                    alert("error", "Login failed - Invalid Credentials!");
                }
            }
        }

        // If the user is not logged in, redirect to index.php
        if (isset($_SESSION["userLogin"]) && $_SESSION["userLogin"] == true){
            $_SESSION["login_page"] = 'denied';
            redirect('index.php');
        }

        if(isset($_GET["error"])){
            if ($_GET["error"]=="401"){
                alert("error", "401 - Unauthorized attempt to view this page.");
            }
        } else if(isset($_SESSION["welcome"])){
            if ($_SESSION["welcome"]==true){
                alert("success", "Welcome back!");
                unset($_SESSION["welcome"]);
                // echo '<script>setTimeout(function() {
                //     window.location.href = "index.php"; // Replace with your desired redirect URL
                //   }, 3000);</script>';
            }
        }
    ?>

<body>
    <div id="auth">
        
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-2">
                        <a href="index"><img src="files/logo.svg" alt="Logo" style="width: 20rem; height: 10vh;"></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>

                    <form action="login.php" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="email" class="form-control form-control-xl" placeholder="Email Address" required>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope-at"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="login">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Don't have an account? <a href="signup.php" class="font-bold" style="color: #435ebe;">Sign
                                up</a>.</p>
                        <p><a class="font-bold" href="forgot-password.php" style="color: #435ebe;">Forgot password?</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>
