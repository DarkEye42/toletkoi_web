<?php
// Database connection
require('include/db_config.php');

// Add category
if ($_POST['action'] == 'add') {
    $categoryName = $_POST['categoryName'];

    $query = "INSERT INTO categories (name) VALUES ('$categoryName')";
    mysqli_query($con, $query);
}

// Edit category
if ($_POST['action'] == 'edit') {
    $categoryId = $_POST['categoryId'];
    $categoryName = $_POST['categoryName'];

    $query = "UPDATE categories SET name='$categoryName' WHERE id='$categoryId'";
    mysqli_query($con, $query);
}

// Delete category
if ($_POST['action'] == 'delete') {
    $categoryId = $_POST['categoryId'];

    $query = "DELETE FROM categories WHERE id='$categoryId'";
    mysqli_query($con, $query);
}

// Get categories
if ($_POST['action'] == 'get') {
    $query = "SELECT * FROM categories";
    $result = mysqli_query($con, $query);

    $output = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<li class="list-group-item d-flex flex-row justify-content-between"><div>' . $row['name'] . '</div>
                        <div>
                            <button class="btn btn-primary btn-sm mx-2" onclick="openEditModal(' . $row['id'] . ', \'' . $row['name'] . '\')">Edit</button>
                            <button class="btn btn-danger btn-sm delete-category" data-id="' . $row['id'] . '">Delete</button>
                        </div>
                    </li>';
    }

    echo $output;
}

// Get categories options
if ($_POST['action'] == 'get_categories') {
    $query = "SELECT * FROM categories";
    $result = mysqli_query($con, $query);

    $options = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }

    echo $options;
}

// Get categories name
if($_POST['action'] == 'get_categories_name'){
    $categoryId = $_POST['categoryId'];

    $query = "SELECT name FROM categories WHERE id = '$categoryId'";
    $result = mysqli_query($con, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $categoryName = $row['name'];
    } else {
        $categoryName = 'Unknown Category';
    }
    
    echo $categoryName;
}

mysqli_close($con);
