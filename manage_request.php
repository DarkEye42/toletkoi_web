<?php
// Database configuration
session_start();
include('admin/include/db_config.php');

// Check if the user is logged in and is an owner
if (!isset($_SESSION['id']) || !$_SESSION['is_owner']) {
    header("Location: index.php");
    exit();
}

// Check if the request_id is provided
if (!isset($_GET['request_id'])) {
    header("Location: owner_dashboard.php");
    exit();
}

$requestID = $_GET['request_id'];

// Get the details of the rental request
$requestQuery = "SELECT rr.id, rr.ad_id, rr.renter_id, rr.status, a.title, a.description, a.cost, u.*
    FROM rental_requests rr
    INNER JOIN rentalposts a ON a.id = rr.ad_id
    INNER JOIN users u ON u.id = rr.renter_id
    WHERE rr.id = $requestID";
$requestResult = $con->query($requestQuery);

if (!$requestResult) {
    // Display the database error
    die("Query error: " . $con->error);
}

// Check if the rental request exists
if ($requestResult->num_rows == 0) {
    header("Location: owner_dashboard.php");
    exit();
}

$requestData = $requestResult->fetch_assoc();
$adID = $requestData['ad_id'];
$renterID = $requestData['renter_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    // Update the status of the rental request
    $updateQuery = "UPDATE rental_requests SET status = '$status' WHERE id = $requestID";
    $updateResult = $con->query($updateQuery);

    // Redirect back to the owner dashboard
    header("Location: owner_dashboard.php");
    exit();
}

// Fetch chat messages
$ownerID = $_SESSION['id'];
$chatsQuery = "SELECT c.id, c.sender_id, c.receiver_id, c.message, c.timestamp, c.seen, u.*
    FROM chats c
    INNER JOIN users u ON u.id = c.sender_id
    WHERE c.receiver_id = $ownerID OR c.receiver_id = $renterID
    ORDER BY c.timestamp DESC";
$chatsResult = $con->query($chatsQuery);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Rental Request</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .chat-container {
            width: auto !important;
            max-height: 520px;
            overflow: auto;
            padding: 10px;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <h2 class="text-center mb-5">Manage Rental Request</h2>
            <div class="col-md-6">
                <h3>Ad Details</h3>
                <p><strong>Title:</strong> <?php echo $requestData['title']; ?></p>
                <p><strong>Cost:</strong> ৳<?php echo $requestData['cost']; ?>/per month</p>
                <p><strong>Description:</strong> <?php echo $requestData['description']; ?></p>
                <h3>Actions</h3>
                <form action="" method="POST">
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="pending" <?php echo ($requestData['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="accepted" <?php echo ($requestData['status'] == 'accepted') ? 'selected' : ''; ?>>Accepted</option>
                        <option value="rejected" <?php echo ($requestData['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                    <br><br>
                    <button type="submit" class="btn btn-outline-success">
                        <i class="bi bi-check-circle-fill"></i>
                        Button
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <h3>Renter Details</h3>
                <div><img src="files/<?= $requestData['avatar'] ?>" alt="" style="width: 100px;" /></div>
                <p><strong>Name:</strong> <?php echo $requestData['first_name'] . ' ' . $requestData['last_name']; ?></p>
                <p><strong>NID:</strong> <?php echo $requestData['nidNumber'];
                                            echo $requestData['isVerified'] > 0 ? ' <i class="bi bi-check-circle-fill text-success"></i>' : null; ?></p>
                <p><strong>Email:</strong> <?php echo $requestData['email'];
                                            echo $requestData['is_email_verified'] > 0 ? ' <i class="bi bi-check-circle-fill text-success"></i>' : null; ?></p>
                <p><strong>Address:</strong> <?= $requestData['village'] . ', ' . $requestData['policeStation'] . ', ' . $requestData['district'] . ' - ' . $requestData['zipCode'] ?></p>
                <h3>Chats</h3>
                <div id="chatContainer" class="chat-container">
                    <?php while ($row = $chatsResult->fetch_assoc()) { ?>
                        <div class="chatMessage">
                            <div class="card mb-3">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="files/<?php echo $row['avatar']; ?>" class="img-fluid rounded-start" alt="..." style="max-width: 100px;">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body p-0">
                                            <strong class="card-title"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></strong> <span class="user-status"></span>
                                            <p class="card-text"><?php echo $row['message']; ?></p>
                                            <p class="card-text"><small class="text-body-secondary"><?php echo $row['seen'] > 0 ? 'Seen' : 'Not Seen'; ?></small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <form id="chatForm" action="send_message.php" method="POST">
                    <input type="hidden" name="receiver_id" value="<?php echo $renterID; ?>">
                    <div class="mb-3">
                        <label for="chatBox" class="form-label">Example textarea</label>
                        <textarea class="form-control" type="text" name="message" placeholder="Type your message..." id="chatBox" rows="3" style="resize: none;"></textarea>
                        <button type="submit" name="chat" class="btn btn-outline-success mt-3">
                            <i class="bi bi-send-fill"></i>
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to check if owner is online
        function checkOwnerStatus() {
            $.ajax({
                url: 'check_status.php',
                success: function(response) {
                    $('.user-status').html(response);
                }
            });
        }

        // Check owner status initially
        checkOwnerStatus();

        // Check owner status every 5 seconds
        setInterval(function() {
            checkOwnerStatus();
        }, 5000);
    });

    // Function to send chat message
    $('#chatForm').submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                // Clear chat input field
                $('#chatForm textarea[name="message"]').val('');

                // Append new message to chat container
                $('#chatContainer').append('<div class="chatMessage"><strong>You</strong> ' + response + '</div>');

                // Scroll to bottom of chat container
                $('#chatContainer').scrollTop($('#chatContainer')[0].scrollHeight);
            }
        });
    });
</script>

</html>