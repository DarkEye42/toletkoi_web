<?php
require('include/essentials.php');
require('include/db_config.php');
adminLogin();

// Handle delete item action
if (isset($_POST['action']) && $_POST['action'] == 'deleteItem') {
    $itemId = $_POST['item_id'];

    // Get item photos from the database
    $query = "SELECT photo1, photo2, photo3 FROM shop WHERE id='$itemId'";
    $result = $con->query($query);
    $item = $result->fetch_assoc();

    // Delete item photos from the server
    if (!empty($item['photo1']) || $item['photo1'] != "") {
        unlink('../files/original/' . $item['photo1']);
        unlink('../files/thumbnail/' . $item['photo1']);
    }
    if (!empty($item['photo2']) || $item['photo2'] != "") {
        unlink('../files/original/' . $item['photo2']);
        unlink('../files/thumbnail/' . $item['photo2']);
    }
    if (!empty($item['photo3']) || $item['photo3'] != "") {
        unlink('../files/original/' . $item['photo3']);
        unlink('../files/thumbnail/' . $item['photo3']);
    }

    // Delete item from the database
    $query = "DELETE FROM shop WHERE id='$itemId'";
    $con->query($query);

    header("Location: shop_items.php");
    exit();
}

// Get all items from the database
$query = "SELECT * FROM shop";
$result = $con->query($query);
$items = array();
//$items = $result->fetch_all(MYSQLI_ASSOC);
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
                <h3 class="mb-4 fw-bold h-font">Shopping System</h3>
                <!-- Main Content -->
                <a href="shop_add_item.php" class="btn btn-primary mb-3">Add Item</a>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) {
                                $items[] = $row; ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td>
                                        <img src="../files/thumbnail/<?= $row['photo1']; ?>" alt="<?php echo $row['id']; ?>" />
                                        <img src="../files/thumbnail/<?= $row['photo2']; ?>" alt="<?php echo $row['id']; ?>" />
                                        <img src="../files/thumbnail/<?= $row['photo3']; ?>" alt="<?php echo $row['id']; ?>" />
                                    </td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td id="category"><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td>
                                        <a href="shop_edit_item.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <form method="post" class="delete-form" style="display:inline;">
                                            <input type="hidden" name="item_id" value="<?= $row['id']; ?>">
                                            <input type="hidden" name="action" value="deleteItem">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Retrieve category names
            $('td#category').each(function() {
                var categoryId = $(this).text();
                var categoryElement = $(this);

                $.ajax({
                    url: 'category',
                    type: 'POST',
                    data: {
                        action: 'get_categories_name',
                        categoryId: categoryId
                    },
                    success: function(response) {
                        categoryElement.text(response);
                    }
                });
            });
        });

        // Delete item form submit handler
        $('.delete-form').submit(function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this item?')) {
                this.submit();
            }
        });
    </script>
    <?php require('../include/scripts.php') ?>
    <?php require('include/commonScripts.php') ?>
</body>

</html>