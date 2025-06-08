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
    <style>
        .short{
            display:inline-block;
            width:100%;
        }

        .img-thumbnail{
            padding: 0 !important;
        }

        .full-image-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .full-image-overlay img {
            max-height: 90vh;
            max-width: 90vw;
        }
    </style>
</head>

<body class="bg-light">

    <?php require('include/header.php') ?>

    <div class="container-fliid" id="main-content">
        <div class="row mt-5">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden mt-auto">
                <h3 class="mb-4 fw-bold h-font">File Manager</h3>
                <div class="short">
                    Short Files As: 
                    <a href="?sort=name">Name</a> | <a href="?sort=date">Date</a> | <a href="?sort=size">Size</a>
                </div>
                <!-- Main Content -->
                <div class="table-responsive">
                    <?php include 'get_fileList.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="full-image-overlay">
        <img src="" alt="Full Image">
    </div>

    <?php require('../include/scripts.php') ?>
    <?php require('include/commonScripts.php') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add click event listener to the image thumbnails
            $('.img-thumbnail').click(function() {
                var imageUrl = $(this).attr('src');
                $('.full-image-overlay img').attr('src', imageUrl);
                $('.full-image-overlay').fadeIn();
            });

            // Add click event listener to the overlay to close it
            $('.full-image-overlay').click(function() {
                $(this).fadeOut();
            });

            // Prevent overlay from closing when clicking on the image itself
            $('.full-image-overlay img').click(function(event) {
                event.stopPropagation();
            });

            // Add click event listener to the button
            $('.delete-btn').click(function() {
                if (confirm("Are you sure you want to delete the file?")) {
                    
                    var data = { file: $(this).data('filename') };
                    var row = $(this).closest('tr');

                    // Send POST request
                    $.post('delete_file.php', data, function(response) {
                        // Check if the response indicates success
                        if (response.success === true) {
                            // Remove the table row on successful file deletion
                            row.remove();
                            //location.reload();
                        } else if (response.success === false) {
                            alert('Error', 'Failed to delete file.');
                        }
                    });
                }
            });
        });
</script>
</body>
</html>