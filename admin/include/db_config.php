<?php
require('config.php');

function filteration($data) {
    foreach ($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
        $value = strip_tags($value);
        $data[$key] = $value;
    }
    return $data;
}


function select($sql, $values, $datatypes)
{
    $con = $GLOBALS["con"];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Select");
        }
    } else {
        die("Query cannot be prepared - Select");
    }
}

function update($sql, $values, $datatypes)
{
    $con = $GLOBALS["con"];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Update");
        }
    } else {
        die("Query cannot be prepared - Update");
    }
}

function insert($sql, $values, $datatypes)
{
    $con = $GLOBALS["con"];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Insert");
        }
    } else {
        die("Query cannot be prepared - Insert");
    }
}

// Web Analytics Tool
// $ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address

// // Make a request to ip-api.com to get geolocation data
// $url = "http://ip-api.com/json/{$ip}";
// $data = json_decode(file_get_contents($url));

// // Get visitor data
// $pageUrl = $_SERVER['REQUEST_URI'];
// $userAgent = $_SERVER['HTTP_USER_AGENT'];

// // Check if the referring URL is set
// if (isset($_SERVER['HTTP_REFERER'])) {
//     $referringUrl = $_SERVER['HTTP_REFERER'];

//     // Extract the domain name from the referring URL
//     $parsedUrl = parse_url($referringUrl);
//     $referringWebsite = $parsedUrl['host'];
// } else {
//     $referringWebsite = "Null";
// }
// // Extract the country from the geolocation data
// $country = isset($data->country) ? $data->country : "Unknown";
// // Get the operating system
// $os = getOSFromUserAgent($userAgent);
// // Get the browser name
// $browser = getBrowserFromUserAgent($userAgent);


// // Insert data into the database
// $query = "INSERT INTO `analytics` (`page_url`, `user_agent`, `browser`, `user_os`, `referring_url`, `country`, `time`) 
//             VALUES ('" . $pageUrl . "', '" . $userAgent . "', '" . $browser . "', '" . $os . "', '" . $referringWebsite . "', '" . $country . "', " . round(microtime(true) * 1000) . ")";
// $con->query($query);

// // Function to extract the operating system from the user agent
// function getOSFromUserAgent($userAgent)
// {
//     $os = "Unknown";

//     $osList = array(
//         '/windows nt 11/i'      =>  'Windows 11',
//         '/windows nt 10/i'      =>  'Windows 10',
//         '/windows nt 6.3/i'     =>  'Windows 8.1',
//         '/windows nt 6.2/i'     =>  'Windows 8',
//         '/windows nt 6.1/i'     =>  'Windows 7',
//         '/windows nt 6.0/i'     =>  'Windows Vista',
//         '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
//         '/windows nt 5.1/i'     =>  'Windows XP',
//         '/windows xp/i'         =>  'Windows XP',
//         '/windows nt 5.0/i'     =>  'Windows 2000',
//         '/windows me/i'         =>  'Windows ME',
//         '/win98/i'              =>  'Windows 98',
//         '/win95/i'              =>  'Windows 95',
//         '/win16/i'              =>  'Windows 3.11',
//         '/macintosh|mac os x/i' =>  'Mac OS X',
//         '/mac_powerpc/i'        =>  'Mac OS 9',
//         '/linux/i'              =>  'Linux',
//         '/ubuntu/i'             =>  'Ubuntu',
//         '/iphone/i'             =>  'iPhone',
//         '/ipod/i'               =>  'iPod',
//         '/ipad/i'               =>  'iPad',
//         '/android/i'            =>  'Android',
//         '/blackberry/i'         =>  'BlackBerry',
//         '/webos/i'              =>  'Mobile'
//     );

//     foreach ($osList as $regex => $value) {
//         if (preg_match($regex, $userAgent)) {
//             $os = $value;
//             break;
//         }
//     }

//     return $os;
// }

$ip = $_SERVER['REMOTE_ADDR'];
$pageUrl = $_SERVER['REQUEST_URI'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$referringWebsite = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : 'Null';
$country = "Unknown";

// Get geolocation data
$url = "http://ip-api.com/json/{$ip}";
$response = file_get_contents($url);
if ($response !== false) {
    $data = json_decode($response);
    if (isset($data->country)) {
        $country = $data->country;
    }
}

$os = getOSFromUserAgent($userAgent);
$browser = getBrowserFromUserAgent($userAgent);

$query = "INSERT INTO analytics (page_url, user_agent, browser, user_os, referring_url, country, time) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";
$values = [$pageUrl, $userAgent, $browser, $os, $referringWebsite, $country, round(microtime(true) * 1000)];
$datatypes = "ssssssi";
insert($query, $values, $datatypes);

// Function to extract the operating system from the user agent
function getOSFromUserAgent($userAgent) {
    $osArray = [
        '/windows nt 11/i' => 'Windows 11',
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
    ];

    foreach ($osArray as $regex => $value) {
        if (preg_match($regex, $userAgent)) {
            return $value;
        }
    }
    return "Unknown";
}

// Function to extract the browser name from the user agent
function getBrowserFromUserAgent($userAgent) {
    $browserArray = [
        '/msie/i' => 'Internet Explorer',
        '/trident/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser',
    ];

    foreach ($browserArray as $regex => $value) {
        if (preg_match($regex, $userAgent)) {
            return $value;
        }
    }
    return "Unknown";
}

// Function to extract the browser name from the user agent
// function getBrowserFromUserAgent($userAgent)
// {
//     $browser = "Unknown";

//     $browserList = array(
//         '/msie/i'       => 'Internet Explorer',
//         '/trident/i'    => 'Internet Explorer',
//         '/firefox/i'    => 'Firefox',
//         '/safari/i'     => 'Safari',
//         '/chrome/i'     => 'Chrome',
//         '/edge/i'       => 'Edge',
//         '/opera/i'      => 'Opera',
//         '/netscape/i'   => 'Netscape',
//         '/maxthon/i'    => 'Maxthon',
//         '/konqueror/i'  => 'Konqueror',
//         '/mobile/i'     => 'Handheld Browser'
//     );

//     foreach ($browserList as $regex => $value) {
//         if (preg_match($regex, $userAgent)) {
//             $browser = $value;
//             break;
//         }
//     }

//     return $browser;
// }

function mostVisitedPage()
{
    $con = $GLOBALS["con"];
    // Get the most visited pages
    $query = "SELECT page_url, COUNT(*) as visit_count 
        FROM analytics 
        GROUP BY page_url 
        ORDER BY visit_count DESC 
        LIMIT 6"; // Change the LIMIT value to display more or fewer pages
    $result = $con->query($query);

    // Prepare the data as an array
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                    <td>" . $row["page_url"] . "</td>
                    <td><label class=\"badge badge-info\">" . $row["visit_count"] . " Times</label></td>
                </tr>";
    }
}

function totalVisit()
{
    $con = $GLOBALS["con"];
    $query = "SELECT * FROM analytics";
    $result = $con->query($query);
    if ($result) {
        $rowCount = $result->num_rows;
        // Display the number of rows
        echo shortNumber($rowCount, 2);
    } else {
        echo "Error!";
    }
}

function shortNumber($number, $decimals = 1)
{
    $suffixes = array('', 'k', 'M', 'B', 'T');
    $suffixIndex = 0;

    if ($number > 999) {
        $suffixes = array('', 'k', 'M', 'B', 'T');
        $suffixIndex = 0;

        while ($number >= 1000 && $suffixIndex < count($suffixes) - 1) {
            $number /= 1000;
            $suffixIndex++;
        }

        return number_format($number, $decimals) . $suffixes[$suffixIndex];
    } else if ($number < 999) {
        return $number;
    }
}

// Set your OpenWeatherMap API key
$apiKey = 'a57dd267ce79ac8e86c4218085f352bf';

// Set the location for which you want to fetch weather data
$city = 'Gazipur';
$countryCode = 'BD';

// Construct the API URL
$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city,$countryCode&appid=$apiKey";

// Make the API request
$response = file_get_contents($apiUrl);

// Check if the API request was successful
if ($response !== false) {
    // Decode the API response as JSON
    $weatherData = json_decode($response, true);

    // Extract the relevant information from the API response
    $temperature = $weatherData['main']['temp'];
    $humidity = $weatherData['main']['humidity'];
    $country = $weatherData['sys']['country'];

    // Display the weather information
    $temp = round($temperature - 273.15);
    $wind = $humidity . "%";
} else {
    // Display an error message if the API request failed
    echo "Unable to retrieve weather data.";
}

function mostVisitedCountry()
{
    $con = $GLOBALS["con"];

    // Fetch the most visited countries
    $query = "SELECT country, COUNT(*) as visit_count
        FROM analytics
        GROUP BY country
        ORDER BY visit_count DESC
        LIMIT 8";

    $result = $con->query($query);

    // Check if the query was successful
    if ($result) {
        // Calculate the total visit count
        $totalVisits = 0;
        while ($row = $result->fetch_assoc()) {
            $totalVisits += $row['visit_count'];

            // Display the results with percentages
            $userCountry = $row['country'];
            $visitCount = $row['visit_count'];
            $percentage = ($visitCount / $totalVisits) * 100;
            echo "<tr>
                    <td>" . $userCountry . "</td>
                    <td><label class=\"badge badge-info\">" . $visitCount . " Times</label></td>
                    <td><label class=\"badge badge-primary\">" . round($percentage, 2) . " %</label></td>
                </tr>";
        }
    } else {
        echo "Error!";
    }
}

// Function to generate a random token
function generateToken()
{
    $length = 32;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
}

// Function to send mail using a template
function sendEmail($emailType, $userEmail, $token){
    $pdo = $GLOBALS["pdo"];
    // Fetch user's first name and last name from the database based on email
    $firstName = "";
    $lastName = "";

    // Prepare and execute the query to fetch user's first name and last name
    $query = "SELECT first_name, last_name FROM users WHERE email = :userEmail";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userEmail', $userEmail);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $firstName = $result['first_name'];
        $lastName = $result['last_name'];
    }

    // Email content based on email type
    $subject = "";
    $url = "";
    $template = "";

    // Determine the email content based on the email type
    switch ($emailType) {
        case 'verify':
            $subject = "Verify Email - ToletKoi";
            $url = "https://toletkoi.com/verify?token=$token";
            $template = file_get_contents('admin/include/email_verify_temp.html');
            $template = str_replace('{url}', $url, $template);
            break;
        case 'password':
            $subject = "Password Reset Request";
            $url = "https://toletkoi.com/reset_password?token=$token";
            $template = file_get_contents('admin/include/forgot_pass_temp.html');
            $username = $firstName . " " . $lastName;
            // Replace the placeholders in the template 
            $template = str_replace('{name}', $username, $template);
            $template = str_replace('{url}', $url, $template);
            break;
            // Add more cases for other email types as needed
        default:
            // Invalid email type
            return false;
    }

    // Set headers
    $senderEmail = "no-reply@toletkoi.com";
    $headers = "From: $senderEmail" . "\r\n";
    $headers .= "Reply-To: $senderEmail" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    try {
        // Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        // Server settings
        $mail->isSMTP();                                 // Send using SMTP
        $mail->Host       = 'server187.web-hosting.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                        // Enable SMTP authentication
        $mail->Username   = 'no-reply@toletkoi.com';     // SMTP username
        $mail->Password   = '@DarkEye-2021!';            // SMTP password
        $mail->SMTPSecure = 'ssl';                      // Enable implicit TLS encryption
        $mail->Port       = 465;                         // TCP port to connect to
    
        // Recipients
        $mail->setFrom($senderEmail, 'ToletKoi');
        $mail->addAddress($userEmail, $firstName . ' ' . $lastName);
    
        //Content
        $mail->isHTML(true);          // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = mb_convert_encoding($template, 'UTF-8');
    
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function time_ago($timestamp)
{
    $current_time = time();
    $time_diff = $current_time - $timestamp;

    if ($time_diff < 60) {
        return "just now";
    } elseif ($time_diff < 60 * 60) {
        $minutes = floor($time_diff / 60);
        return $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
    } elseif ($time_diff < 60 * 60 * 24) {
        $hours = floor($time_diff / (60 * 60));
        return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
    } elseif ($time_diff < 60 * 60 * 24 * 7) {
        $days = floor($time_diff / (60 * 60 * 24));
        return $days . " day" . ($days > 1 ? "s" : "") . " ago";
    } else {
        return date("F j, Y", $timestamp);
    }
}

function millsToDate($milliseconds)
{
    $seconds = floor($milliseconds / 1000); // Convert milliseconds to seconds
    $date = DateTime::createFromFormat('U', $seconds); // Create DateTime object from seconds
    return $date->format('d M Y'); // Format the date as desired
}

// Function to add views to the views table
function addView($adID, $ownerID)
{
    $con = $GLOBALS["con"];
    // Check if the user is logged in
    if (isset($_SESSION["userLogin"]) && $_SESSION["userLogin"] == true) {
        $userID = $_SESSION['id'];
        // Check if the user ID exists
        $checkUserQuery = "SELECT * FROM users WHERE id = $userID";
        $userResult = $con->query($checkUserQuery);

        // Check if the user viewed already
        $checkViewQuery = "SELECT * FROM views WHERE user_id = $userID AND ads_id = $adID";
        $viewsResult = $con->query($checkViewQuery);

        if ($userResult->num_rows > 0) {
            if ($viewsResult->num_rows > 0) {
                // User ID exists & view set then update the view
                $updateQuery = "UPDATE views SET time = NOW() WHERE user_id = $userID AND ads_id = $adID";
                if ($con->query($updateQuery) === TRUE) {
                    //View added/updated successfully
                } else {
                    echo "Error adding/updating view: " . $con->error;
                }
            } else {
                // User ID exists & view not set then add the view
                $updateQuery = "INSERT INTO views (user_id, owner_id, ads_id, time) VALUES ($userID, $ownerID, $adID, NOW())
                    ON DUPLICATE KEY UPDATE time = NOW()";
                if ($con->query($updateQuery) === TRUE) {
                    //View added/updated successfully
                } else {
                    echo "Error adding/updating view: " . $con->error;
                }
            }
        } else {
            echo "Invalid user ID";
        }
    } else {
        $userIP = md5($_SERVER['REMOTE_ADDR']);

        // Check if the IP exists
        $checkIPQuery = "SELECT * FROM views WHERE user_ip = '$userIP' AND ads_id = $adID";
        $ipResult = $con->query($checkIPQuery);
        if ($ipResult->num_rows === 0) {
            // IP does not exist, add the view
            $insertQuery = "INSERT INTO views (user_id, owner_id, ads_id, user_ip, time) VALUES (NULL, $ownerID, $adID, '$userIP', NOW())";
            if ($con->query($insertQuery) === TRUE) {
                //View added successfully
            } else {
                echo "Error adding view: " . $con->error;
            }
        }
    }
}

// Function to retrieve total views for an ad
function getAdsViews($adID)
{
    // Connect to the database
    $conn = $GLOBALS["con"];
    // Retrieve the total views for the ad
    $sql = "SELECT COUNT(*) AS total_views FROM views WHERE ads_id = $adID";
    $result = $conn->query($sql);

    $totalViews = 0;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalViews = $row['total_views'];
    }

    return $totalViews;
}

// Function to check if user already liked an ad
function userHasLikedAd($userID, $adID)
{
    // Connect to the database
    $conn = $GLOBALS['con'];
    // Check if the user already liked the ad
    $sql = "SELECT id FROM likes WHERE user_id = $userID AND ad_id = $adID";
    $result = $conn->query($sql);

    $userLikedAd = false;

    if ($result->num_rows > 0) {
        $userLikedAd = true;
    }

    return $userLikedAd;
}

// Function to add a like for a user on an ad
function addLike($userID, $adID, $postOwner)
{
    // Connect to the database
    $conn = $GLOBALS['con'];
    $addLike = false;
    // Insert the like into the likes table
    $sql = "INSERT INTO likes (user_id, ad_id, post_owner) VALUES ('$userID', '$adID', '$postOwner')";
    if ($conn->query($sql) === TRUE) {
        $addLike = true;
    } else {
        // Display the database error
        die("Query error: " . $conn->error);
    }

    return $addLike;
}

function getPostImages($uniqueId)
{
    try {
        $pdo = $GLOBALS["pdo"];
        $stmt = $pdo->prepare("SELECT * FROM postimages WHERE ads_id = :adsId ORDER BY ");
        $stmt->bindParam(':adsId', $uniqueId);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    } finally {
        $pdo = null; // Close the connection
    }
}

function load_division()
{
    $con = $GLOBALS["con"];
    $output = '';
    $sql = "SELECT * FROM  divisions ORDER BY name";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
            //$output .= 'Div id: '.$row["id"].' Div Name: '.$row["name"].$_POST[''];
        }
    }
    return $output;
}


function resizeImage($file, $width, $height)
{
    $info = getimagesize($file);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
        case 'image/jpg':
            $source_image = imagecreatefromjpeg($file);
            break;
        case 'image/png':
            $source_image = imagecreatefrompng($file);
            break;
        case 'image/gif':
            $source_image = imagecreatefromgif($file);
            break;
        default:
            return false; // Unsupported image type
    }

    $resized_image = imagecreatetruecolor($width, $height);
    imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, $width, $height, imagesx($source_image), imagesy($source_image));
    ob_start();
    switch ($mime) {
        case 'image/jpeg':
        case 'image/jpg':
            imagejpeg($resized_image, null, 100); // Change the last parameter (quality) as needed
            break;
        case 'image/png':
            imagepng($resized_image);
            break;
        case 'image/gif':
            imagegif($resized_image);
            break;
    }
    $image_data = ob_get_clean();
    imagedestroy($source_image);
    imagedestroy($resized_image);
    return $image_data;
}

function randomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    $charCount = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charCount - 1)];
    }

    return $randomString;
}

function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $r = json_decode(html_entity_decode($response), true)["geocoded_address"];
    curl_close($curl);
    return $r;
}

function getRentalPosts()
{

    $pdo = $GLOBALS['pdo'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT rp.*, pi.path
        FROM rentalposts rp
        LEFT JOIN postimages pi ON rp.uniqueId = pi.ads_id
        ORDER BY rp.uniqueId, pi.date DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $pdo = null; // Close the connection
    }
}

function getImages($uniqueId)
{
    $pdo = $GLOBALS['pdo'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM postimages WHERE ads_id = :uniqueId");
        $stmt->bindParam(':uniqueId', $uniqueId);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $pdo = null; // Close the connection
    }
}

function getAllPosts()
{
    $pdo = $GLOBALS['pdo'];
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM rentalposts ORDER BY rentalposts.date DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $pdo = null; // Close the connection
    }
}

function getSimilarPosts($ps, $category)
{
    $pdo = $GLOBALS['pdo'];
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM rentalposts WHERE policeStation = '$ps' AND category = '$category' ORDER BY rentalposts.date DESC LIMIT 12";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $pdo = null; // Close the connection
    }
}

function getPageLinks($category, $currentPage, $perPage)
{
    $pdo = $GLOBALS['pdo'];
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Count the total number of posts that match the criteria
        $countSql = "SELECT COUNT(*) AS total FROM rentalposts 
                     WHERE category = :category";
        
        $stmt = $pdo->prepare($countSql);
        $stmt->bindParam(":category", $category, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalPosts = $row['total'];

        // Calculate the total number of pages
        $totalPages = ceil($totalPosts / $perPage);

        // Generate pagination links
        $pagination = '';
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                $pagination .= "<li class='page-item active'><a class='page-link'>$i</a></li>";
            } else {
                $pagination .= "<li class='page-item'><a class='page-link' href='explore/category/$category/$i'>$i</a></li>";
            }
        }

        return $pagination;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $pdo = null; // Close the connection
    }
}

function getCatPosts($category, $page, $perPage)
{
    $pdo = $GLOBALS['pdo'];
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Calculate the offset based on the current page and items per page
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM rentalposts 
                WHERE category = :category 
                ORDER BY rentalposts.date DESC 
                LIMIT :offset, :perPage";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":category", $category, PDO::PARAM_STR);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":perPage", $perPage, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $pdo = null; // Close the connection
    }
}


function getAreaPosts($ps)
{
    $pdo = $GLOBALS['pdo'];
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM rentalposts WHERE policeStation = '$ps' ORDER BY rentalposts.date DESC LIMIT 12";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $pdo = null; // Close the connection
    }
}

function getCategoryPosts($category)
{
    $pdo = $GLOBALS['pdo'];
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM rentalposts WHERE category = '$category' ORDER BY rentalposts.date DESC LIMIT 12";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $pdo = null; // Close the connection
    }
}

function getTotalLikes($ads_id) {
    $pdo = $GLOBALS['pdo'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT COUNT(*) AS total_likes FROM likes WHERE ad_id = :ads_id");
        $stmt->bindParam(':ads_id', $ads_id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_likes'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    } finally {
        $pdo = null; // Close the connection
    }
}

function isEmailExist($email) {
    $pdo = $GLOBALS['pdo'];
    try {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $count = $stmt->fetchColumn();
        
        return $count > 0;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function dataExist($phone, $nid, $username) {

    $pdo = $GLOBALS['pdo'];

    // Check if the phone number already exists
    $phoneCheckSql = "SELECT * FROM users WHERE phone = :phone";
    $phoneCheckStmt = $pdo->prepare($phoneCheckSql);
    $phoneCheckStmt->bindParam(":phone", $phone);
    $phoneCheckStmt->execute();
    
    // Check if the nid number already exists
    $nidCheckSql = "SELECT * FROM users WHERE nidNumber = :nid";
    $nidCheckStmt = $pdo->prepare($nidCheckSql);
    $nidCheckStmt->bindParam(":nid", $nid);
    $nidCheckStmt->execute();
    
    // Check if the username already exists
    $usernameCheckSql = "SELECT * FROM users WHERE username = :username";
    $usernameCheckStmt = $pdo->prepare($usernameCheckSql);
    $usernameCheckStmt->bindParam(":username", $username);
    $usernameCheckStmt->execute();
    
    if ($phoneCheckStmt->rowCount() > 0) {
        return "Phone number already in use. Please choose a different phone number.";
    } elseif ($nidCheckStmt->rowCount() > 0) {
        return "NID number already in use. Please choose a different NID number.";
    } elseif ($usernameCheckStmt->rowCount() > 0) {
        return "Username already in use. Please choose a different username.";
    }
    
    return "";
}

function uploadAvatar($fileInputName, $targetDirectory) {
    // Check if file was uploaded without errors
    if(isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        // Get file name and extension
        $originalFileName = basename($_FILES[$fileInputName]['name']);
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        // Generate a unique name for the file to prevent overwriting
        $newFileName = uniqid() . '.' . $extension;

        // Set the target path for the uploaded file
        $targetPath = $targetDirectory . $newFileName;

        // Check if the file is an image
        $isImage = getimagesize($_FILES[$fileInputName]['tmp_name']);

        if ($isImage !== false) {
            // Resize the image to 300x300 pixels
            $image = imagecreatefromstring(file_get_contents($_FILES[$fileInputName]['tmp_name']));
            $resizedImage = imagescale($image, 300, 300);

            // Convert the image to webp format and save it
            imagewebp($resizedImage, 'files/'.$targetPath);

            // Clean up the resources
            imagedestroy($image);
            imagedestroy($resizedImage);

            // Return the path to the converted image
            return $targetPath;
        } else {
            return 'not_image';
        }
    } else {
        return "error_image";
    }

    // Return null in case of errors
    return null;
}

?>
