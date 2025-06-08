<?php
include('../admin/include/essentials.php');
// Validate the secret key sent from the AJAX request
$accessToken = 'NDQ4NTpUNU5PNTBKOVZJ';
$secretKey = $_POST['secretKey']; // Secret key sent from the AJAX request
$validSecretKey = hash('sha256', 'accessToken'); // Replace with your actual secret key

if ($secretKey !== $validSecretKey) {
    // Invalid secret key, return an empty response or an error message
    exit();
}

// Validate the referer to ensure it comes from an allowed domain
$allowedDomains = array('rentalorb.com', 'www.rentalorb.com', 'app.rentalorb.com', 'localhost'); // Add your allowed domains here

$referer = $_SERVER['HTTP_REFERER'];
$parsedReferer = parse_url($referer);
if (!$referer || !in_array($parsedReferer['host'], $allowedDomains)) {
    alert('error', 'Invalid referer provided');
    // Referer is invalid or not from an allowed domain, return an empty response or an error message
    exit();
}

// Retrieve the API key from a secure location, such as the server environment variables or a secure file
//$apiKey = getenv('BARIKOI_API_KEY'); // Example: using environment variables
$apiKey = $accessToken;
// Echo the API key in the response
echo $apiKey;
?>
