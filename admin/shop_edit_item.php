<?php
    require('include/essentials.php');
    require('include/db_config.php');
    adminLogin();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle edit item action
        if (isset($_POST['action']) && $_POST['action'] == 'editItem') {
            $itemId = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
    
            // Update item in the database
            $query = "UPDATE shop SET name='$name', description='$description', price='$price' WHERE id='$itemId'";
            $con->query($query);
            $con->close();
    
            header("Location: shop_items.php");
            exit();
        }
    }
    
    // Get item details from the database
    $itemId = $_GET['id'];
    $query = "SELECT * FROM shop WHERE id='$itemId'";
    $result = $con->query($query);
    $item = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <?php require('include/commonLinks.php') ?>
</head>
<body class="bg-light">
    
    <?php require('include/header.php') ?>

    <div class="container-fliid" id="main-content">
        <div class="row mt-5">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden mt-auto">
                <h3 class="mb-4 fw-bold h-font">Edit Item Info</h3>
                <!-- Main Content -->
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required value="<?php echo $item['name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required><?php echo $item['description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required value="<?php echo $item['price']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Item</button>
                    <input type="hidden" name="action" value="editItem">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <?php require('../include/scripts.php') ?>
    <?php require('include/commonScripts.php') ?>
</body>
</html>