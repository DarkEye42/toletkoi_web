<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - ToletKoi</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <?php include('include/commonLinks.php');?>
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.php"><img src="files/logo.svg" alt="Logo" style="width: 20rem; height: 10vh;"></a>
                    </div>
                    <h1 class="auth-title">Reset Password</h1>


                    <?php
                    // Configuration settings
                    include('admin/include/db_config.php');
                    $host = DB_HOST;
                    $db = DB_NAME;
                    $user = DB_USER;
                    $password = DB_PASS;
                    $resetLinkValidity = 30; // Reset token validity in minutes

                    // Establish database connection
                    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Retrieve the token from the query string
                    if (isset($_POST['token'])) {
                        $token = $_POST['token'];
                    } else if (isset($_GET['token'])) {
                        $token = $_GET['token'];
                    } else {
                        $token = null;
                    }

                    $notify = "";
                    $success = 0;

                    // Check if the token is valid and within the token validity period
                    $stmt = $conn->prepare('SELECT user_id FROM reset_pass_verify WHERE token = :token AND created_at >= NOW() - INTERVAL :token_validity MINUTE');
                    $stmt->execute(['token' => $token, 'token_validity' => $resetLinkValidity]);
                    $resetData = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>

                    <?php
                    if ($resetData) {
                        // Process the submitted password reset form
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $password = $_POST['password'];
                            $confirmPassword = $_POST['confirm_password'];

                            if ($password === $confirmPassword) {
                                // Update the user's password in the users table
                                $hashedPassword = md5($password);
                                $stmt = $conn->prepare('UPDATE users SET password = :password WHERE id = :user_id');
                                $stmt->execute(['password' => $hashedPassword, 'user_id' => $resetData['user_id']]);

                                // Delete the reset token from the reset_pass_verify table
                                $stmt = $conn->prepare('DELETE FROM reset_pass_verify WHERE token = :token');
                                $stmt->execute(['token' => $token]);

                                $notify = "<div class=\"alert alert-success text-center\" role=\"alert\">
                    Your password has been successfully reset. You can now log in with your new password. Goto <a href=\"login.php\" class=\"alert-link\">Login Page</a>.
                </div>";
                                $success = 1;
                            } else {
                                $notify = "<div class=\"alert alert-warning alert-dismissible fade show text-center\" role=\"alert\">
                <strong>Error!</strong> Password and confirm password do not match.
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
                            }
                        }
                    } else {
                        echo "<div class=\"alert alert-danger align-items-center text-center\" role=\"alert\">
            Invalid or expired token. <br/> Please back to <a href=\"index.php\" class=\"alert-link\">Home Page</a>.
        </div>";
                    }

                    if ($resetData) {
                        echo $notify;
                        if ($success != 1) {
                    ?>
                            <form method="post">
                                <input type="hidden" name="token" value="<?php echo $token; ?>">
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="password" class="form-control form-control-xl" name="confirm_password" placeholder="Confirm Password">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Update</button>
                            </form>
                    <?php
                        }
                    }
                    ?>
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