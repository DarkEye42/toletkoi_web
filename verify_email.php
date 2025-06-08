<?php
    session_start();
    require_once 'admin/include/db_config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify Email</title>
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
    <div class="container mt-5 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 align-self-center">
                <h3>Welcome to email verification center!</h3>
                <div id="verification-status">
                    <?php include 'include/check_verification_status.php'; ?>
                </div>
                <div id="verification-buttons" class="mt-3">
                    <?php include 'include/verification_buttons.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to handle the verification button clicks
        $(document).ready(function() {
            $('#verify-email-send-button').click(function() {
                $.ajax({
                    url: 'include/verification_handler.php',
                    type: 'POST',
                    data: { action: 'send' },
                    success: function(response) {
                        $("#verification-status").html(response);
                        $("#verification-buttons").html("");
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#verify-email-resend-button').click(function() {
                $.ajax({
                    url: 'include/verification_handler.php',
                    type: 'POST',
                    data: { action: 'resend' },
                    success: function(response) {
                        $("#verification-status").html(response);
                        $("#verification-buttons").html("");
                    }
                });
            });
        });
    </script>
</body>
</html>