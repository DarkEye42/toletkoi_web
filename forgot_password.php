<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuration settings
include('admin/include/db_config.php');
$host = DB_HOST;
$db = DB_NAME;
$user = DB_USER;
$password = DB_PASS;
$fromEmail = 'no-reply@rentalorb.com'; // Email address from which the reset email will be sent
$resendCooldown = 5; // Cooldown time in minutes before allowing another reset email to be sent
$notify = "";

// Establish database connection
$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    $stmt = $conn->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check if a reset email was sent within the cooldown time
        $stmt = $conn->prepare('SELECT created_at FROM reset_pass_verify WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1');
        $stmt->execute(['user_id' => $user['id']]);
        $lastResetEmail = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$lastResetEmail || time() - strtotime($lastResetEmail['created_at']) >= $resendCooldown * 60) {
            // Generate a unique token and insert it into reset_pass_verify table
            $token = bin2hex(random_bytes(32));
            $stmt = $conn->prepare('INSERT INTO reset_pass_verify (user_id, token) VALUES (:user_id, :token)');
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
<html>
<head>
    <title>Reset Password</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12 align-self-center">
                <div class="card border-0 shadow my-3">
                    <div class="card-body">
                        <h3 class="card-title text-center">Forgot Your Password?</h3>
                        <?=$notify;?>
                        <form method="post">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="emailInput" placeholder="Email" required>
                                <label for="emailInput">Enter your email address</label>
                            </div>
                            <div class="d-grid gap-2 d-md-block">
                                <a class="btn btn-outline-secondary" role="button" aria-disabled="true" href="index.php">Cancel</a>
                                <input type="submit" id="submitButton" class="btn btn-warning" value="Send Verification Email">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
