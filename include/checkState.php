<?php
// Database connection code
include('../admin/include/db_config.php');

// Get the user ID and ad ID from the POST request
$userID = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$adID = isset($_POST['ad_id']) ? $_POST['ad_id'] : null;
$postOwner = isset($_POST['post_owner']) ? $_POST['post_owner'] : null;

if($_POST['check'] == 'likes'){
    // Check if the user already liked the ad
    if (userHasLikedAd($userID, $adID)) {
        echo "liked";
    } else {
        echo "not_liked";
    }
} else if ($_POST['check'] == 'unLikes') {
    // Delete the like from the likes table
    $sql = "DELETE FROM likes WHERE user_id = '$userID' AND ad_id = '$adID'";
    if ($con->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
} else if($_POST['check'] == 'adsLiked'){
    // Check if the user already liked the ad
    if (addLike($userID, $adID, $postOwner)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
