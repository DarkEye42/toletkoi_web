<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ToletKoi</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <?php include('include/commonLinks.php');?>
</head>
<?php
    require("admin/include/db_config.php");
    require("admin/include/essentials.php");
    // User registration
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['signup'] == 'true') {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $confirm_pass = $_POST['confirm_pass'];

        if (empty($first_name)) {
            alert('error', 'First name cannot be empty!');
        } elseif (empty($last_name)) {
            alert('error', 'Last name cannot be empty!');
        } elseif (empty($email)) {
            alert('error', 'Email cannot be empty!');
        } elseif (empty($pass)) {
            alert('error', 'Password cannot be empty!');
        } elseif (empty($confirm_pass)) {
            alert('error', 'Confirm password cannot be empty!');
        } elseif ($pass != $confirm_pass) {
            alert('error', 'Incorrect confirm password!');
        } elseif (isEmailExist($email)) {
            alert('error', 'This email is already exist! Please try to login.');
        } else {
            // All input checks passed
            $password = md5($pass);
            // Generate new email verification token
            $token = bin2hex(random_bytes(32));
            // User Unique ID
            $uniqueID = randomString(12);
            // Random Username
            $username = randomString(8);
            // Join Date
            $joinDate = round(microtime(true) * 1000);
            //$dob = strtotime($dateOfBirth) * 1000;
    
            try {
                // Insert user data into the database
                $stmt = $pdo->prepare("INSERT INTO users (username, unique_id, first_name, last_name, email, password, joinDate) VALUES (:username, :uniqueID, :first_name, :last_name, :email, :password, :joinDate)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':uniqueID', $uniqueID);
                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':last_name', $last_name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':joinDate', $joinDate);
                $stmt->execute();
                
                // Insert user verification data into the database
                verifyMail($email, $token);

                // Send verification email
                if (sendEmail('verify', $email, $token)) {
                    $_SESSION['register'] = 'success';
                    redirect('index.php');
                } else {
                    alert('error', 'Error sending verification email.');
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    function verifyMail($email, $token) {

        $pdo = $GLOBALS['pdo'];

        try {
            $query = "INSERT INTO verification (email, token) VALUES (:email, :token)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            
            return $token;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
?>
<body>
    <div id="auth">
        
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-2">
                        <a href="index.php"><img src="files/logo.svg" alt="Logo" style="width: 20rem; height: 20vh;"></a>
                    </div>
                    <h1 class="auth-title">Sign Up</h1>
                    <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

                    <form method="POST">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-6 ps-1">
                                    <div class="form-group position-relative has-icon-left mb-4">
                                        <input type="text" class="form-control form-control-xl" name="first_name" placeholder="First Name" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 pe-1">
                                    <div class="form-group position-relative has-icon-left mb-4">
                                        <input type="text" class="form-control form-control-xl" name="last_name" placeholder="Last Name" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="email" placeholder="Email" required>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="pass" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="confirm_pass" placeholder="Confirm Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn icon icon-left btn-primary btn-block btn-lg shadow-lg mt-5" name="signup" value="true"> <i class="bi bi-box-arrow-in-right fs-4"></i> Sign Up </button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Already have an account? <a href="login.php" class="font-bold" style="color: #435ebe;">
                        Log in</a>.</p>
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
