<?php
    require_once 'admin/include/db_config.php';
    require_once 'admin/include/essentials.php';

    if (isset($_GET['token'])) {
        $token = $_GET['token'];

        try {
            // Check if the token exists and is not expired
            $query = "SELECT email FROM verification WHERE token = :token AND created_at >= NOW() - INTERVAL 2 HOUR";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $uEmail = $row['email'];

                // Update the user's verification status
                $updateQuery = "UPDATE users SET is_email_verified = 1 WHERE email = :uEmail";
                $updateStmt = $pdo->prepare($updateQuery);
                $updateStmt->bindParam(':uEmail', $uEmail);
                $updateStmt->execute();

                // Delete the verification token
                $deleteQuery = "DELETE FROM verification WHERE token = :token";
                $deleteStmt = $pdo->prepare($deleteQuery);
                $deleteStmt->bindParam(':token', $token);
                $deleteStmt->execute();

                $_SESSION['verify'] = 'success';
                redirect('index.php');
            } else {
                $_SESSION['verify'] = 'failed';
                redirect('index.php');
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['verify_token'] = '404';
        redirect('index.php');
    }
?>