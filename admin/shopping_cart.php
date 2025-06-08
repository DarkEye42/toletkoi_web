<?php
    require('include/essentials.php');
    require('include/db_config.php');
    adminLogin();

    // Fetch products from the database
    $query = "SELECT * FROM shop";
    $result = $con->query($query);

    // Handle add to cart action
    if (isset($_POST['action']) && $_POST['action'] == 'addToCart') {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        // Fetch product details
        $query = "SELECT * FROM shop WHERE id = $productId";
        $productResult = $con->query($query);
        $product = $productResult->fetch_assoc();

        // Create cart item array
        $cartItem = array(
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity
        );

        // Add item to the session cart array
        if (!empty($_SESSION['cart_item'])) {
            if (array_key_exists($productId, $_SESSION['cart_item'])) {
                $_SESSION['cart_item'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['cart_item'][$productId] = $cartItem;
            }
        } else {
            $_SESSION['cart_item'][$productId] = $cartItem;
        }
    }

    // Handle remove from cart action
    if (isset($_POST['action']) && $_POST['action'] == 'removeFromCart') {
        $productId = $_POST['product_id'];

        // Remove item from session cart array
        if (!empty($_SESSION['cart_item'])) {
            unset($_SESSION['cart_item'][$productId]);
        }
    }
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <div class="container-fliid" id="main-content">
        <div class="row mt-5">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden mt-auto">
                <h3 class="mb-4 fw-bold h-font">Shopping Cart System</h3>
                <!-- Main Content -->
                <div class="row">
                    <div class="col-md-6">
                        <h2>Products</h2>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $row['id'] . '</td>';
                                            echo '<td>' . $row['name'] . '</td>';
                                            echo '<td>' . $row['price'] . '</td>';
                                            echo '<td>
                                                <form method="post">
                                                    <div class="input-group mb-3">
                                                        <a class="btn btn-outline-secondary btn-fw" id="decrease-btn-' . $row['id'] . '">-</a>
                                                            <input type="number" class="form-control" id="quantity-' . $row['id'] . '" name="quantity" step="1" min="1" value="1" required>
                                                        <a class="btn btn-outline-secondary btn-fw" id="increase-btn-' . $row['id'] . '">+</a>
                                                    </div>
                                                </td>';
                                            echo '<td>
                                                    <input type="hidden" name="product_id" value="' . $row['id'] . '">
                                                    <input type="hidden" name="action" value="addToCart">
                                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                                </form>
                                            </td>';
                                            echo '</tr>';
                                        ?>
                                            <script>
                                                $(document).ready(function() {
                                                    // Increase button click event
                                                    $('#increase-btn-<?=$row['id'];?>').click(function() {
                                                        var value = parseInt($('#quantity-<?=$row['id'];?>').val());
                                                        value++;
                                                        $('#quantity-<?=$row['id'];?>').val(value);
                                                    });

                                                    // Decrease button click event
                                                    $('#decrease-btn-<?=$row['id'];?>').click(function() {
                                                        var value = parseInt($('#quantity-<?=$row['id'];?>').val());
                                                        if (value > 1) {
                                                        value--;
                                                        $('#quantity-<?=$row['id'];?>').val(value);
                                                        }
                                                    });
                                                });
                                            </script>
                                        <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <h2>Cart</h2>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($_SESSION['cart_item'])) {
                                        foreach ($_SESSION['cart_item'] as $item) {
                                            echo '<tr>';
                                            echo '<td>' . $item['id'] . '</td>';
                                            echo '<td>' . $item['name'] . '</td>';
                                            echo '<td>' . $item['price'] . '</td>';
                                            echo '<td>' . $item['quantity'] . '</td>';
                                            echo '<td>
                                                <form method="post">
                                                    <input type="hidden" name="product_id" value="' . $item['id'] . '">
                                                    <input type="hidden" name="action" value="removeFromCart">
                                                    <button type="submit" class="btn btn-danger">Remove</button>
                                                </form>
                                            </td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <?php require('../include/scripts.php') ?>
    <?php require('include/commonScripts.php') ?>
</body>
</html>