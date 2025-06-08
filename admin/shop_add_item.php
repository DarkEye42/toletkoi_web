<?php
require('include/essentials.php');
require('include/db_config.php');
adminLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Handle add item action
    if (isset($_POST['action']) && $_POST['action'] == 'addItem') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $category = $_POST['categorySelect'];

        // Handle photo uploads
        $photo1 = '';
        $photo2 = '';
        $photo3 = '';

        if ($_FILES['photo1']['error'] === UPLOAD_ERR_OK) {
            $tempName = $_FILES['photo1']['tmp_name'];
            $photo1 = saveAndResizePhoto($tempName);
        }

        if ($_FILES['photo2']['error'] === UPLOAD_ERR_OK) {
            $tempName = $_FILES['photo2']['tmp_name'];
            $photo2 = saveAndResizePhoto($tempName);
        }

        if ($_FILES['photo3']['error'] === UPLOAD_ERR_OK) {
            $tempName = $_FILES['photo3']['tmp_name'];
            $photo3 = saveAndResizePhoto($tempName);
        }

        // Insert item into the database
        $microtime = round(microtime(true) * 1000);
        $query = "INSERT INTO shop (name, description, category, price, photo1, photo2, photo3, quantity, date)
                      VALUES ('$name', '$description', '$category', '$price', '$photo1', '$photo2', '$photo3', '$quantity', '$microtime')";
        $con->query($query);
        $con->close();

        header("Location: shop_items.php");
        exit();
    }
}

// Function to save and resize the photo
function saveAndResizePhoto($tempName)
{
    // Get image details
    $imageInfo = getimagesize($tempName);
    $imageWidth = $imageInfo[0];
    $imageHeight = $imageInfo[1];

    // Resize image if needed
    $maxWidth = 800;
    $maxHeight = 800;
    if ($imageWidth > $maxWidth || $imageHeight > $maxHeight) {
        $aspectRatio = $imageWidth / $imageHeight;

        if ($imageWidth > $imageHeight) {
            $newWidth = $maxWidth;
            $newHeight = $newWidth / $aspectRatio;
        } else {
            $newHeight = $maxHeight;
            $newWidth = $newHeight * $aspectRatio;
        }

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Load original image
        $originalImage = imagecreatefromstring(file_get_contents($tempName));

        // Resize the image
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);

        // Save the resized image
        $photoName = uniqid() . '.jpg';
        $photoPath = '../files/original/' . $photoName;
        imagejpeg($newImage, $photoPath, 90);

        // Compress image to reduce file size
        compressImage($photoPath, '../files/thumbnail/' . $photoName, 200);

        // Destroy images from memory
        imagedestroy($originalImage);
        imagedestroy($newImage);

        return $photoName;
    }

    return '';
}

// Function to compress image without losing quality
function compressImage($source, $destination, $quality)
{
    $imageInfo = getimagesize($source);

    if ($imageInfo['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
        imagejpeg($image, $destination, $quality);
    } elseif ($imageInfo['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
        imagepng($image, $destination, ($quality / 9));
    }

    return $destination;
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

    <div class="container-fliid" id="main-content">
        <div class="row mt-5">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden mt-auto">
                <h3 class="mb-4 fw-bold h-font">Add Item to Shop</h3>
                <!-- Main Content -->
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" style="line-height: 5;" id="description" name="description" required></textarea>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-3 col-md-3">
                            <label for="categorySelect" class="form-label">Category</label>
                            <select class="form-control" id="categorySelect" name="categorySelect" required>
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-3 col-md-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                        </div>
                        <div class="mb-3 col-lg-3 col-md-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" step="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="photo1" class="form-label">Photo 1</label>
                        <input type="file" class="form-control" id="photo1" name="photo1" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo2" class="form-label">Photo 2</label>
                        <input type="file" class="form-control" id="photo2" name="photo2" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo3" class="form-label">Photo 3</label>
                        <input type="file" class="form-control" id="photo3" name="photo3" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                    <input type="hidden" name="action" value="addItem">
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <?php require('../include/scripts.php') ?>
    <?php require('include/commonScripts.php') ?>
    <script>
        $(document).ready(function () {
            // Load categories on page load
            loadCategories();
        });

        function loadCategories() {
            $.ajax({
                url: 'category',
                type: 'POST',
                data: { action: 'get_categories' },
                success: function (response) {
                    $('#categorySelect').html(response);
                }
            });
        }
    </script>
</body>

</html>