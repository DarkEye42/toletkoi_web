<?php
// Database configuration
session_start();
include('admin/include/db_config.php');

// Check if the user is logged in and is not an owner
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Fetch rental requests for the renter
$renterID = $_SESSION['id'];
$requestsQuery = "SELECT rr.id, rr.ad_id, rr.status, a.title, u.first_name, u.last_name
    FROM rental_requests rr
    INNER JOIN rentalposts a ON a.id = rr.ad_id
    INNER JOIN users u ON u.id = a.post_owner
    WHERE rr.renter_id = $renterID";
$requestsResult = $con->query($requestsQuery);
// Fetch utility bills for the renter
$billsQuery = "SELECT b.id, b.amount, b.month, b.year, a.title, u.first_name, u.last_name
    FROM utility_bills b
    INNER JOIN rentalposts a ON a.id = b.ad_id
    INNER JOIN users u ON u.id = a.post_owner
    WHERE b.renter_id = $renterID";
$billsResult = $con->query($billsQuery);

// Fetch chat messages
$chatsQuery = "SELECT c.id, c.sender_id, c.receiver_id, c.message, c.timestamp, c.seen, u.*
    FROM chats c
    INNER JOIN users u ON u.id = c.sender_id
    WHERE c.sender_id = $renterID OR c.receiver_id = $renterID
    ORDER BY c.timestamp DESC";
$chatsResult = $con->query($chatsQuery);
if (!$chatsResult) {
    // Display the database error
    die("Query error: " . $con->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Renter Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Renter Dashboard</h2>
        <h3>Rental Requests</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Ad Title</th>
                    <th>Owner</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $requestsResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['first_name'].' '. $row['last_name']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Utility Bills</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Ad Title</th>
                    <th>Owner</th>
                    <th>Amount</th>
                    <th>Month</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $billsResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['first_name'].' '. $row['last_name']; ?></td>
                        <td>$<?php echo $row['amount']; ?></td>
                        <td><?php echo $row['month']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Chats</h3>
        <div id="chatContainer">
            <?php while ($row = $chatsResult->fetch_assoc()) { ?>
                <div class="chatMessage">
                    <strong><?php echo $row['first_name'].' '. $row['last_name']; ?></strong> <?php echo $row['message']; ?>
                </div>
            <?php } ?>
        </div>
        <form id="chatForm" action="send_message.php" method="POST">
            <input type="hidden" name="receiver_id" value="<?php echo $ownerID; ?>">
            <input type="text" name="message" placeholder="Type your message...">
            <button type="submit">Send</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to check if renter is online
            function checkRenterStatus() {
                $.ajax({
                    url: 'check_status.php',
                    success: function(response) {
                        $('.user-status').html(response);
                    }
                });
            }

            // Check renter status initially
            checkRenterStatus();

            // Check renter status every 5 seconds
            setInterval(function() {
                checkRenterStatus();
            }, 5000);

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
                        $('#chatForm input[name="message"]').val('');

                        // Append new message to chat container
                        $('#chatContainer').append('<div class="chatMessage"><strong>You</strong> ' + response + '</div>');

                        // Scroll to bottom of chat container
                        $('#chatContainer').scrollTop($('#chatContainer')[0].scrollHeight);
                    }
                });
            });
        });
    </script>
</body>
</html>