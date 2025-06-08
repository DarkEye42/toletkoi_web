<?php
    require('include/essentials.php');
    require('include/db_config.php');
    adminLogin();

    
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
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="mb-4 fw-bold h-font">Add Category</h2>
                        <form id="categoryForm" method="POST">
                            <div class="form-group">
                                <label for="categoryName" class="font-weight-bold">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h2 class="mb-4 fw-bold h-font">Categories</h2>
                        <ul class="list-group mb-1">
                            <li class="d-flex flex-row justify-content-between">
                                <p class="font-weight-bold">Category Name</p>
                                <p class="font-weight-bold">Category Actions</p>
                            </li>
                        </ul>
                        <ul id="categoryList" class="list-group">
                            <!-- Category list will be dynamically updated here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <input type="hidden" id="editCategoryId" name="editCategoryId">
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editCategoryName" name="editCategoryName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Load categories on page load
            loadCategories();

            // Add category form submission
            $('#categoryForm').submit(function (e) {
                e.preventDefault();
                var categoryName = $('#categoryName').val();

                $.ajax({
                    url: 'category',
                    type: 'POST',
                    data: { categoryName: categoryName, action: 'add' },
                    success: function (response) {
                        $('#categoryName').val('');
                        loadCategories();
                    }
                });
            });

            // Edit category form submission
            $('#editCategoryForm').submit(function (e) {
                e.preventDefault();
                var categoryId = $('#editCategoryId').val();
                var categoryName = $('#editCategoryName').val();

                $.ajax({
                    url: 'category',
                    type: 'POST',
                    data: { categoryId: categoryId, categoryName: categoryName, action: 'edit' },
                    success: function (response) {
                        $('#editCategoryModal').modal('hide');
                        loadCategories();
                    }
                });
            });

            // Delete category
            $(document).on('click', '.delete-category', function () {
                var categoryId = $(this).data('id');

                if (confirm('Are you sure you want to delete this category?')) {
                    $.ajax({
                        url: 'category',
                        type: 'POST',
                        data: { categoryId: categoryId, action: 'delete' },
                        success: function (response) {
                            loadCategories();
                        }
                    });
                }
            });
        });

        function loadCategories() {
            $.ajax({
                url: 'category',
                type: 'POST',
                data: { action: 'get' },
                success: function (response) {
                    $('#categoryList').html(response);
                }
            });
        }

        function openEditModal(categoryId, categoryName) {
            $('#editCategoryId').val(categoryId);
            $('#editCategoryName').val(categoryName);
            $('#editCategoryModal').modal('show');
        }
    </script>
    <?php require('../include/scripts.php') ?>
    <?php require('include/commonScripts.php') ?>
</body>
</html>