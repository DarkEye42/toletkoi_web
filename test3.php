<?php
include('admin/include/db_config.php');
// Connect to the MySQL database
$mysqli = $con;

// Function to calculate the per share value
function calculatePerShareValue($totalShares, $companyValue)
{
    if ($totalShares > 0) {
        return $companyValue / $totalShares;
    }
    return 0;
}

// Function to update shareholders' share percentages
function updateSharePercentages($mysqli)
{
    $result = $mysqli->query("SELECT SUM(shares) AS totalShares FROM shareholders");
    $row = $result->fetch_assoc();
    $totalShares = $row['totalShares'];

    $result = $mysqli->query("SELECT * FROM shareholders");
    while ($row = $result->fetch_assoc()) {
        $shares = $row['shares'];
        $percentage = ($shares / $totalShares) * 100;

        $mysqli->query("UPDATE shareholders SET percentage = $percentage WHERE id = " . $row['id']);
    }
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $shares = $_POST['shares'];

    // Insert the new share record
    $mysqli->query("INSERT INTO shareholders (name, shares) VALUES ('$name', $shares)");

    // Update the share percentages
    updateSharePercentages($mysqli);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shareholder Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Shareholder Management</h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Shareholder Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="shares" class="form-label">Number of Shares</label>
                <input type="number" class="form-control" id="shares" name="shares" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Shareholder</button>
        </form>

        <h2>Shareholders</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Shares</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve the shareholders from the database
                $result = $mysqli->query("SELECT * FROM shareholders");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['shares']}</td>";
                    echo "<td>{$row['percentage']}%</td>";
                    echo "</tr>";
                }

                // Calculate the per share value
                $result = $mysqli->query("SELECT SUM(shares) AS totalShares FROM shareholders");
                $row = $result->fetch_assoc();
                $totalShares = $row['totalShares'];
                $companyValue = 1000000; // Example company value

                $perShareValue = calculatePerShareValue($totalShares, $companyValue);
                echo "<p>Per Share Value: $perShareValue</p>";

                // Close the database connection
                $mysqli->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>