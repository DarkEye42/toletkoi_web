<?php
// Database configuration
session_start();
include('admin/include/db_config.php');
// Check if the user is logged in and is an owner
if (!isset($_SESSION['id']) || !$_SESSION['is_owner']) {
    header("Location: index.php");
    exit();
}

// Fetch rental requests for the owner
$ownerID = $_SESSION['id'];
$requestsQuery = "SELECT rr.id, rr.ad_id, rr.renter_id, rr.status, a.title,  u.first_name, u.last_name
    FROM rental_requests rr
    INNER JOIN rentalposts a ON a.id = rr.ad_id
    INNER JOIN users u ON u.id = rr.renter_id
    WHERE a.post_owner = $ownerID";
$requestsResult = $con->query($requestsQuery);
$totalRequest = $requestsResult->num_rows;

// Fetch ad statistics
$adsQuery = "SELECT id, title, views, likes FROM rentalposts WHERE post_owner = $ownerID";
$adsResult = $con->query($adsQuery);
$totalAds = $adsResult->num_rows;

if (!$adsResult) {
    // Display the database error
    die("Query error: " . $con->error);
}

// Fetch account balance
$balanceQuery = "SELECT balance FROM users WHERE id = $ownerID";
$balanceResult = $con->query($balanceQuery);
$row = $balanceResult->fetch_assoc();
$balance = $row['balance'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Owner Dashboard</h2>
        <h3>Rental Requests</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Ad Title</th>
                    <th>Renter</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $requestsResult->fetch_assoc()) { ?>
                    <tr>
                        <td><a href="adsDetails.php?ads=<?= $row['id'] ?>"><?php echo $row['title']; ?></a></td>
                        <td><?php echo $row['first_name'].' '. $row['last_name']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><a href="manage_request.php?request_id=<?php echo $row['id']; ?>">Manage</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Ad Statistics</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Views</th>
                    <th>Likes</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $adsResult->fetch_assoc()) { ?>
                    <tr>
                        <td><a href="adsDetails.php?ads=<?= $row['id'] ?>"><?php echo $row['title']; ?></a></td>
                        <td><?php echo $row['views']; ?></td>
                        <td><?php echo $row['likes']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Account Balance: $<?php echo $balance; ?></h3>
    </div>
</body>
</html>