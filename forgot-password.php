<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuration settings
require("admin/include/db_config.php");
require("admin/include/essentials.php");
$fromEmail = 'no-reply@rentalorb.com'; // Email address from which the reset email will be sent
$resendCooldown = 5; // Cooldown time in minutes before allowing another reset email to be sent
$notify = "";

// Function to send reset password email
function sendEmail2($email, $token){
    global $fromEmail;
    $subject = 'Reset Your Password';
    $message = "Click on the following link to reset your password: \n\n";
    $message .= "https://rentalorb.com/reset_password?token=" . $token;
    $headers = "From: $fromEmail\r\n";
    $headers .= "Reply-To: $fromEmail\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/plain;charset=UTF-8\r\n";
    return mail($email, $subject, $message, $headers);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if user exists with the given email
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check if a reset email was sent within the cooldown time
        $stmt = $pdo->prepare('SELECT created_at FROM reset_pass_verify WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1');
        $stmt->execute(['user_id' => $user['id']]);
        $lastResetEmail = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$lastResetEmail || time() - strtotime($lastResetEmail['created_at']) >= $resendCooldown * 60) {
            // Generate a unique token and insert it into reset_pass_verify table
            $token = bin2hex(random_bytes(32));
            $stmt = $pdo->prepare('INSERT INTO reset_pass_verify (user_id, token) VALUES (:user_id, :token)');
            $stmt->execute(['user_id' => $user['id'], 'token' => $token]);

            // Send the reset email
            if (sendEmail('password', $email, $token)) {
                $notify = "<div class=\"alert alert-success alert-dismissible fade show text-center\" role=\"alert\">
                    Reset email sent successfully. Please check your email to reset your password. Goto <a href=\"index.php\" class=\"alert-link\">Home Page</a>.
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                </div>";
            } else {
                $notify = "<div class=\"alert alert-danger alert-dismissible fade show text-center\" role=\"alert\">
                    <strong>Error!</strong> Failed to send reset email. Please try again later.
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                </div>";
            }
        } else {
            $notify = "<div class=\"alert alert-warning alert-dismissible fade show text-center\" role=\"alert\">
                    Please wait for $resendCooldown minutes before requesting another reset email.
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                </div>";
        }
    } else {
        $notify = "<div class=\"alert alert-danger alert-dismissible fade show text-center\" role=\"alert\">
                User with the provided email does not exist.
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - ToletKoi</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <?php include('include/commonLinks.php');?>
</head>

<body>
    <div id="auth">
        
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-2">
                        <a href="index.php"><img src="files/logo.svg" alt="Logo" style="width: 20rem; height: 10vh;"></a>
                    </div>
                    <h1 class="auth-title">Forgot Password</h1>
                    <p class="auth-subtitle mb-5">Input your email and we will send you reset password link.</p>
                    <?=$notify;?>
                    <form action="forgot-password.php" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Remember your account? <a href="login.php" class="font-bold" style="color: #435ebe;">Log in</a>.
                        </p>
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
