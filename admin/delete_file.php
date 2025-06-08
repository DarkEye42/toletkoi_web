<?php
$directory = '../files/images/post'; // Replace with the actual directory path

if (isset($_POST['file'])) {
    $fileName = $_POST['file'];
    $filePath = $directory . '/' . $fileName;

    if (file_exists($filePath) && is_file($filePath)) {
        if (unlink($filePath)) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false);
        }
    } else {
        $response = array('success' => false);
    }

    echo json_encode($response);
}
?>