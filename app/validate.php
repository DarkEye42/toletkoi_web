<?php
function validate($data) {
    // Check if the input is an array, if so recursively sanitize each element
    if (is_array($data)) {
        return array_map('validate', $data);
    }
    
    // Trim the input to remove extra spaces
    $data = trim($data);
    
    // Remove backslashes (\)
    $data = stripslashes($data);
    
    // Convert special characters to HTML entities to prevent XSS
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    return $data;
}

// Additional functions for specific types of input
function validateEmail($email) {
    $email = validate($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false; // or handle invalid email appropriately
    }
    return $email;
}

function validateInt($number) {
    $number = validate($number);
    if (!filter_var($number, FILTER_VALIDATE_INT)) {
        return false; // or handle invalid integer appropriately
    }
    return (int) $number;
}

function validateFloat($number) {
    $number = validate($number);
    if (!filter_var($number, FILTER_VALIDATE_FLOAT)) {
        return false; // or handle invalid float appropriately
    }
    return (float) $number;
}
?>
