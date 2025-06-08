<!DOCTYPE html>
<html lang="en">
<?php
    require("admin/include/db_config.php");
    require("admin/include/essentials.php");
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php
            // Get the Unique ID from the query string
            $id = isset($_GET['ads']) ? $_GET['ads'] : null;
            // Fetch data from the database
            $sql = "SELECT * FROM rentalposts WHERE uniqueId = '$id'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $title = $row['category']. ' ' .$row['building_type'];
                echo '<title>'. mb_convert_case($title, MB_CASE_TITLE, "UTF-8") .' - ToletKoi </title>';
                echo '<meta name="description" content="'. $row['description']. '">';
            }
        ?>
    <meta name="robots" content="index, follow">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var originalTitle = document.title;
            document.title = originalTitle.charAt(0).toUpperCase() + originalTitle.slice(1);
        });
    </script>
    <?php include('include/commonLinks.php') ?>
    <link rel="stylesheet" href="include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.barikoi.com/bkoi-gl-js/dist/bkoi-gl.css">
    <script src="https://cdn.barikoi.com/bkoi-gl-js/dist/bkoi-gl.js"></script>
    <style>
        #map {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 70vh;
            overflow: hidden;
            border-radius: 10px;
        }

        .h-max {
            max-height: 420px;
            min-height: 420px;
            padding: 2px;
        }

        @media screen and (max-width: 991px) {
            .h-max {
                max-height: 275px;
                min-height: 275px;
                padding: 2px;
            }
        }

        .mapboxgl-ctrl-bottom-left,
        .mapboxgl-ctrl-bottom-right {
            display: none !important;
        }

        .facility-text {
            color: #4f7178;
        }

        .img-h {
            max-height: 220px;
            min-height: 220px;
        }

        .rating {
            font-size: 24px;
        }

        .star {
            display: inline-block;
            cursor: pointer;
        }

        .star:hover,
        .star.active {
            color: gold !important;
        }
    </style>
</head>

<body>
    <div id="app">
    <?php include('include/sidebar2.php') ?>
    <!-- Main Section Start -->
        <div id="main" class="layout-navbar">
            <header class="mb-3 sticky-top bg-white">
                <?php include('include/navbar.php') ?>
            </header>
            <div id="main-content" class="p-2 mt-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row mt-4">
                                <?php
                                // Get the ID from the query string
                                $id = isset($_GET['ads']) ? $_GET['ads'] : null;
                                // Post id
                                $pid = '';
                                $postOwner = 0;
                                //$id = 44;
                                // Fetch data from the database
                                $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM rentalposts WHERE uniqueId = '$id'"));
                                    if ($row) {
                                        $uid = $row['post_owner'];
                                        $pid = $row['id'];
                                        $postOwner = $row['post_owner'];
                                        $sql_u = "SELECT * FROM users WHERE id = '$uid'";
                                        $result_u = $con->query($sql_u);

                                        // Calling add views function
                                        isset($pid) ? addView($pid, $uid) : null;

                                    if ($result_u->num_rows > 0) {
                                        $urow = $result_u->fetch_assoc();
                                        // PHP code to calculate the average rating

                                        // Query to calculate the average rating
                                        $query = "SELECT AVG(rating) AS average_rating FROM ratings WHERE product_id = $pid";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                        $averageRating = $result['average_rating'];
                                        $rating = round($averageRating, 1);

                                        if ($rating >= 5) {
                                            $ratingStar = '<i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>';
                                        } else if ($rating == 4) {
                                            $ratingStar = '<i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>';
                                        } else if ($rating == 3) {
                                            $ratingStar = '<i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>';
                                        } else if ($rating == 2) {
                                            $ratingStar = '<i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>';
                                        } else if ($rating == 1) {
                                            $ratingStar = '<i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>';
                                        } else {
                                            $ratingStar = '<i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>
                                            <i class="bi bi-star text-warning"></i>';
                                        }

                                        // Query to retrieve the reviews
                                        $query = "SELECT * FROM ratings WHERE product_id = $pid ORDER BY id DESC";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();
                                        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if (isset($_POST['review'])) {
                                            // Get the submitted rating and review
                                            $productID = $_POST['product_id'];
                                            $rating = $_POST['rating'];
                                            $comment = $con->real_escape_string($_POST['comment']);
                                            $uri = $_SERVER['PHP_SELF'] . '?ads=' . $pid;

                                            // Insert the rating and review into the database
                                            $time = microtime(true);
                                            // Convert the time to milliseconds
                                            $milliseconds = round($time * 1000);
                                            $date = time();
                                            $sql_i = "INSERT INTO ratings (product_id, uid, date, rating, review) VALUES ('$productID', '" . $_SESSION['id'] . "', '$milliseconds', '$rating', '$comment')";
                                            // Execute the query
                                            if ($con->query($sql_i) === true) {
                                                alert('success', 'Review submitted successfully');
                                                redirect($uri);
                                            } else {
                                                alert('error', $con->error);
                                            }
                                        }

                                        $noReviw = $reviews == null ? '<h2 class="text-center text-secondary fw-bold mt-5">No Reviews Found!</h2>' : null;

                                ?>
                                        <!-- Ads Details Secttion -->
                                        <div class="col-lg-6 col-12">
                                            <div class="card mb-3">
                                                <!-- Image Slider -->
                                                <div id="carousel<?= $row['uniqueId'] ?>" class="carousel slide">
                                                    <div class="carousel-inner">
                                                        <?php
                                                            $postsAndImages = getImages($row['uniqueId']);

                                                            if ($postsAndImages) {
                                                                foreach ($postsAndImages as $key => $post) {
                                                                    // If it's the first image, add the 'active' class for the Bootstrap carousel
                                                                    $activeClass = $key === 0 ? 'active' : '';

                                                                    // Use the $activeClass in your carousel HTML
                                                                    echo '<div class="ratio ratio-4x3 carousel-item ' . $activeClass . '" style="z-index: auto;">';
                                                                    echo '<img class="img-fluid rounded p-0" src="' . $post['path'] . '" alt="Image" loading="lazy">';
                                                                    echo '</div>';
                                                                }
                                                            } else {
                                                                echo '<div class="ratio ratio-4x3 carousel-item active" style="z-index: auto;">';
                                                                echo '<img class="img-fluid rounded p-0" src="files/noimage.png" alt="Image" loading="lazy">';
                                                                echo '</div>';
                                                            }
                                                        ?>
                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $row['uniqueId'] ?>" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $row['uniqueId'] ?>" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>
                                                <!-- Card Body -->
                                                <div class="card-body">
                                                    <h3 class="capitalize"><?= $row['category']. ' ' .$row['building_type'] ?></h3>
                                                    <div class="card shadow p-3 mx-1">
                                                        <p class="card-text"><i class="bi bi-person-fill-check" style="color: #378cb5; font-weight: bold; font-size: 20px;"></i>
                                                            <?= $urow['first_name'] . ' ' . $urow['last_name'] ?> |
                                                            <i class="bi bi-geo-alt-fill" style="color: #e75297;"></i>
                                                            <small class="text-secondary">
                                                                <?= $row['house_no'] . ', ' . $row['street'] . ', ' . $row['policeStation'] . ', ' . $row['district'] ?>
                                                            </small>
                                                        </p>
                                                        <p class="card-text">
                                                            <span class="mx-1"><i class="bi bi-patch-check-fill" style="color: #2b891f;"></i> Address Checked</span>
                                                            <!-- <i class="bi bi-check-circle-fill" style="color: #1982bf;"></i> NID Verified &bull; -->
                                                            <span class="mx-1"><i class="bi bi-envelope-check-fill" style="color: #1982bf;"></i> Email verified</span>
                                                            <span class="mx-1"><i class="bi bi-check-circle-fill" style="color: #1982bf;"></i> Phone verified</span>
                                                        </p>

                                                        <p class="card-text mt-2 d-flex grid gap-3">
                                                            <span>
                                                                <i class="bi bi-building" style="color: #1982bf;"></i>
                                                                <span class="fw-bold text-secondary">
                                                                    Building Type: <span class="capitalize" style="color: #528be1;"><?= $row['building_type'] ?></span>
                                                                </span>
                                                            </span>
                                                            <span>
                                                                <i class="bi bi-calendar-day" style="color: #1982bf;"></i>
                                                                <span class="fw-bold text-secondary capitalize">
                                                                    Available From: <i style="color: #2b891f;"><?= $row['takeOver'] ?></i>
                                                                </span>
                                                            </span>
                                                            <span>
                                                                <i class="bi bi-map-fill" style="color: #1982bf;"></i>
                                                                <span class="fw-bold text-secondary">
                                                                    <a href="https://www.google.com/maps/search/?api=1&query=<?= $row["latitude"]; ?>,<?= $row["longitude"]; ?>" target="_blank">
                                                                        <span style="color: #e75297;">View in Google Map</span>
                                                                    </a>
                                                                </span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <p class="card-text">
                                                        <h5 class="text-secondary fw-bold">Post Description</h5>
                                                        <?= $row['description'] ?>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <p class="card-text">
                                                                <h5 class="text-secondary fw-bold">Facilities</h5>
                                                                <ul class="fw-bold text-opacity-75 facility-text">
                                                                    <?php
                                                                    echo $row['electricity'] != 'No' ? '<li>Electricity supply</li>' : '<li class="text-danger">No electricity supply</li>';
                                                                    echo $row['water'] != 'No' ? '<li>Drinkable water supply</li>' : '<li class="text-danger">No water supply</li>';
                                                                    echo $row['gas'] != 'No' ? '<li>Gas supply</li>' : '<li class="text-danger">No Gas Supply</li>';
                                                                    echo $row['internet'] != 'No' ? '<li>Fastes Internet supply</li>' : null;
                                                                    echo $row['ac'] != 'No' ? '<li>Air Condition System</li>' : null;
                                                                    echo $row['elevator'] != 'No' ? '<li>Elevator facility</li>' : null;
                                                                    ?>
                                                                </ul>
                                                            </p>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <p class="card-text row">
                                                                <h5 class="text-secondary fw-bold">Costing &amp; Contact</h5>
                                                                <?php
                                                                echo '<p><span class="fw-bolder text-info fs-3">৳' . $row['cost'] . '</span><b class="fs-5 text-info-emphasis">/per Month</b></p>';
                                                                echo '<p>
                                                                            <a class="btn btn-outline-success btn-sm mb-1" type="button" href="#"> <i class="bi bi-person-lines-fill"></i> Request Contact Info </a>
                                                                        </p>';
                                                                echo '<div class="row">
                                                                <p class="col-6">
                                                                            <span class="fw-bold fs-5 text-secondary">Rating: </span>
                                                                            <span class="badge rounded-pill bg-light">
                                                                                ' . $ratingStar . '
                                                                            </span>
                                                                        </p>';
                                                                        if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true){
                                                                            echo '<span class="col-6">
                                                                            <span class="fw-bold fs-5 text-secondary">Like This Ads? </span>
                                                                            <button class="btn btn-sm btn-outline-success likeButton" data-adid="'.$pid.'" data-adsOwner="'.$row['post_owner'].'">
                                                                            </button>
                                                                        </span>';
                                                                        }
                                                                ?>
                                                                </div>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <p class="card-text">
                                                                <h5 class="text-secondary fw-bold">Features</h5>
                                                                <ul class="fw-bold text-opacity-75 facility-text">
                                                                    <?php
                                                                    $rooms = $row['rooms'] > 1 ? $row['rooms'] . ' Bedrooms' : $row['rooms'] . ' Bedroom';
                                                                    $washrooms = $row['bathroom'] > 1 ? $row['bathroom'] . ' Bathrooms' : $row['bathroom'] . ' Bathroom';
                                                                    $balcony = $row['balcony'] > 1 ? $row['balcony'] . ' Balconies' : $row['balcony'] . ' Balcony';
                                                                    $kitchen = $row['kitchen'] == 'Yes' ? '<li>Kitchen room included</li>' : null;
                                                                    echo '<li>' . $rooms . '</li>';
                                                                    echo $row['bathroom'] != 0 ? '<li>' . $washrooms . '</li>' : null;
                                                                    echo $row['balcony'] != 0 ? '<li>' . $balcony . '</li>' : null;
                                                                    echo $kitchen;
                                                                    ?>
                                                                </ul>
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p class="card-text">
                                                                <h5 class="text-secondary fw-bold">Terms &amp; Conditions</h5>
                                                                <p class="fw-0 text-opacity-75 facility-text">
                                                                    <?php
                                                                    // Renter Type Family or Bachelor
                                                                    if ($row['category'] == 'bachelor') {
                                                                        $allowedRenters = 'Only bachelors renters &amp; ';
                                                                    } else if ($row['category'] == 'family') {
                                                                        $allowedRenters = 'Only family type of renters &amp; ';
                                                                    } else {
                                                                        $allowedRenters = 'Bachelor, family or any types of renters can apply.';
                                                                    }

                                                                    echo $allowedRenters . ' Smoking, drinking, playing song louder, and how many guests are allowed at a time are negotiable.';
                                                                    
                                                                    $timestamp = strtotime($row['date']); // Replace with your timestamp
                                                                    $time_ago = time_ago($timestamp);
                                                                    ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <p class="card-text text-end"><small class="text-body-secondary">Last updated:
                                                            <?= $time_ago ?></small></p>
                                                </div>
                                            </div>
                                            <!-- More Ads Section -->
                                            <h4 class="mt-3 text-center fw-bold facility-text">Similar Rentals You May Like</h4>
                                            <div class="row row-cols-2 row-cols-md-3 g-4 mb-4">

                                            <?php
                                        $bachelorPosts = getSimilarPosts($row['policeStation'], $row['category']);

                                        if ($bachelorPosts) {
                                            foreach ($bachelorPosts as $row) {
                                                echo '<div class="mb-n30px">
                                                            <div class="card shadow">
                                                                <div id="carousel_similar_rentals' . $row['uniqueId'] . '" class="carousel slide">
                                                                    <div class="carousel-inner">';

                                                $postsAndImages = getImages($row['uniqueId']);

                                                if ($postsAndImages) {
                                                    foreach ($postsAndImages as $key => $post) {
                                                        // If it's the first image, add the 'active' class for the Bootstrap carousel
                                                        $activeClass = $key === 0 ? 'active' : '';

                                                        // Use the $activeClass in your carousel HTML
                                                        echo '<div class="ratio ratio-4x3 carousel-item ' . $activeClass . '" style="z-index: auto;">';
                                                        echo '<img class="img-fluid rounded p-0" src="' . $post['path'] . '" alt="Image" loading="lazy">';
                                                        echo '</div>';
                                                    }
                                                } else {
                                                    echo '<div class="ratio ratio-4x3 carousel-item active" style="z-index: auto;">';
                                                    echo '<img class="img-fluid rounded p-0" src="files/noimage.png" alt="Image" loading="lazy">';
                                                    echo '</div>';
                                                }

                                                echo '</div>
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel_similar_rentals' . $row['uniqueId'] . '" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel_similar_rentals' . $row['uniqueId'] . '" data-bs-slide="next">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Next</span>
                                                                </button>
                                                            </div>
                                                            <a href="property/details/' . $row['uniqueId'] . '">
                                                                <div class="card-body px-2 py-3">
                                                                    <h6 class="card-text mb-1 capitalize">
                                                                        ' . $row['category'] . ' ' . $row['building_type'] . '
                                                                    </h6>
                                                                    <p class="card-text">
                                                                        <span class="text-secondary" style="font-size: 12px;">
                                                                            <i class="bi bi-geo-alt-fill" style="font-size: 14px;"></i>
                                                                            ' . $row['policeStation'] . ', ' . $row['district'] . '
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>';
                                            }
                                        } else {
                                            echo "No results found.";
                                        }
                                        ?>

                                            </div>
                                        </div>
                                        <!-- Map Section -->
                                        <div class="col-lg-6 col-12" style="overflow: hidden;">
                                            <div id="map" class="shadow border-1"></div>

                                            <!-- Review Section -->
                                            <form method="POST">
                                                <div class="mb-3 mt-5">
                                                    <label for="comment" class="form-label facility-text fw-bold">Write a review</label>
                                                    <textarea class="form-control" maxlength="240" id="comment" name="comment" placeholder="Write your review" rows="5" style="resize: none;" required></textarea>
                                                    <input type="hidden" name="product_id" value="<?= $id ?>">
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="mb-3 col-lg-6">
                                                        <div class="fs-5">
                                                            <span class="fw-bold text-secondary">Select Rating: </span>
                                                            <span class="star text-secondary" data-rating="1"><i class="bi bi-star-fill"></i></span>
                                                            <span class="star text-secondary" data-rating="2"><i class="bi bi-star-fill"></i></span>
                                                            <span class="star text-secondary" data-rating="3"><i class="bi bi-star-fill"></i></span>
                                                            <span class="star text-secondary" data-rating="4"><i class="bi bi-star-fill"></i></span>
                                                            <span class="star text-secondary" data-rating="5"><i class="bi bi-star-fill"></i></span>
                                                            <input type="hidden" name="rating" id="rating-value" value="1">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-lg-3 offset-md-3">
                                                        <?php
                                                        $login_toggle = !isset($_SESSION['id']) ? 'type="button" data-bs-toggle="modal" data-bs-target="#loginModel"' : 'type="submit" name="review"';
                                                        ?>
                                                        <button <?= $login_toggle ?> class="btn btn-outline-secondary text-end">
                                                            <i class="bi bi-send-plus-fill"></i> Submit Review
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- Review Comment Section -->
                                            <h4 class="mt-3 fw-bold facility-text">Recent Reviews</h4>
                                            <?php
                                            error_reporting(E_ALL);
                                            ini_set('display_errors', 1);
                                            foreach ($reviews as $review) {
                                                // Retrieve Username
                                                $query = "SELECT * FROM users WHERE id = " . $review['uid'] . "";
                                                $timestamp = strtotime(millisecondsToDate($review['date'])); // Replace with your timestamp
                                                $time_ago = time_ago($timestamp);
                                                // Execute the query
                                                $result = $con->query($query);
                                                if ($result) {
                                                    // Fetch the single data
                                                    $row = $result->fetch_assoc();

                                                    // Define Rating Section
                                                    if ($review['rating'] == 5) {
                                                        $ratingReview = '<i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>';
                                                    } else if ($review['rating'] == 4) {
                                                        $ratingReview = '<i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>';
                                                    } else if ($review['rating'] == 3) {
                                                        $ratingReview = '<i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>';
                                                    } else if ($review['rating'] == 2) {
                                                        $ratingReview = '<i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>';
                                                    } else if ($review['rating'] == 1) {
                                                        $ratingReview = '<i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>';
                                                    } else {
                                                        $ratingReview = '<i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>';
                                                    }

                                                    echo '<div class="card mb-12 mb-4" style="max-width: 100%;">
                                                        <div class="row g-0">
                                                            <div class="col">
                                                                <div class="card-body">
                                                                    <p class="card-title fw-bold fs-5 text-secondary"><i class="bi bi-person-circle"></i> ' . $row['first_name'] . ' ' . $row['last_name'] . '</p>
                                                                    <p class="card-text fw-0 text-opacity-75 facility-text">Comment: ' . $review['review'] . '</p>
                                                                    <div class="row justify-content-between">
                                                                    <p class="col-6">
                                                                        <span class="card-text fw-bold text-secondary">Rating: </span>
                                                                        <span class="badge rounded-pill bg-light">
                                                                            ' . $ratingReview . '
                                                                        </span>
                                                                    </p>
                                                                        <p class="card-text col-6 text-end">
                                                                            <small class="text-body-secondary">Last update: ' . $time_ago . '</small>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                }
                                            }
                                            echo $noReviw; ?>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    redirect('index.php');
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
                $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM rentalposts WHERE id = '$pid'"));
            ?>
            <?php include('include/footer.php'); ?>
        </div>
    <!-- Main Section End -->
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
         var xhr = new XMLHttpRequest();
        xhr.open("POST", "include/proxy", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var token = xhr.responseText; // Retrieve the API key from the response
                loadMap(token); // Call the function to load the map with the API key
            }
        };
        xhr.send("secretKey=94a2776e7bd6f611462bc4344e17773c65fc4c486401643b724d102a8936dff4");
        function loadMap(token) {
            bkoigl.accessToken = token // required
            const map = new bkoigl.Map({
                draggable: false,
                container: 'map',
                center: [<?= $row["longitude"] ?>, <?= $row["latitude"] ?>],
                zoom: 15
            })
            
            // Add Marker on Map Load
            map.on('load', () => {
                const marker = new bkoigl.Marker({
                        draggable: false
                    })
                    .setLngLat([<?= $row["longitude"] ?>, <?= $row["latitude"] ?>])
                    .addTo(map)
            })

            map.on('load', () => {
                // Add Fullscreen Control
                map.addControl(
                    new bkoigl.FullscreenControl()
                )

                // Add Zoom Navigation Control
                map.addControl(
                    new bkoigl.NavigationControl()
                )

                // Add Map Scale Control
                map.addControl(
                    new bkoigl.ScaleControl()
                )
            })
        }
        
        $(document).ready(function() {
            // Initialize the rating
            var selectedRating = 0;

            // Handle star click event
            $('.star').click(function() {
                // Remove active class from all stars
                $('.star').removeClass('active');

                // Get the selected rating from the data attribute
                selectedRating = $(this).data('rating');

                // Add active class to selected stars
                $(this).prevAll('.star').addClass('active');
                $(this).addClass('active');

                // Set the selected rating value in the hidden input field
                $('#rating-value').val(selectedRating);
            });
        });
        <?php if(isset($_SESSION['id'])){?>
            $(document).ready(function() {
                // Function to check if user already liked the ad
                function checkIfUserLikedAd(userID, adID) {
                    $.ajax({
                    type: "POST",
                    url: "include/checkState",
                    data: { check: 'likes', user_id: userID, ad_id: adID },
                    success: function(response) {
                        if (response === "liked") {
                        // User already liked the ad
                        $(".likeButton[data-adid='" + adID + "']").html('<i class="bi bi-heart-fill"></i> Unlike Ads');
                        $(".likeButton[data-adid='" + adID + "']").addClass("btn-outline-danger").removeClass("btn-outline-success");
                        } else {
                            $(".likeButton[data-adid='" + adID + "']").html('<i class="bi bi-heart-fill"></i> Like Ads');
                            $(".likeButton[data-adid='" + adID + "']").addClass("btn-outline-success").removeClass("btn-outline-danger");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", error);
                    }
                    });
                }

                // Function to like an ad
                function likeAd(userID, adID, postOwner) {
                    $.ajax({
                    type: "POST",
                    url: "include/checkState",
                    data: { check: 'adsLiked', user_id: userID, ad_id: adID, post_owner: postOwner },
                    success: function(response) {
                        if (response === "success") {
                        // Like added successfully
                        $(".likeButton[data-adid='" + adID + "']").html('<i class="bi bi-heart-fill"></i> Unlike Ads');
                        $(".likeButton[data-adid='" + adID + "']").addClass("btn-outline-danger").removeClass("btn-outline-success");
                        console.log("Ad liked!");
                        } else {
                        console.log("Error:", response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", error);
                    }
                    });
                }

                // Function to unlike an ad
                function unlikeAd(userID, adID) {
                    $.ajax({
                    type: "POST",
                    url: "include/checkState",
                    data: { check: 'unLikes', user_id: userID, ad_id: adID },
                    success: function(response) {
                        if (response === "success") {
                        // Unlike successful
                        $(".likeButton[data-adid='" + adID + "']").html('<i class="bi bi-heart-fill"></i> Like Ads');
                        $(".likeButton[data-adid='" + adID + "']").addClass("btn-outline-success").removeClass("btn-outline-danger");
                        console.log("Ad unliked!");
                        } else {
                        console.log("Error:", response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", error);
                    }
                    });
                }

                // Event listener for like button clicks
                $(document).on("click", ".likeButton", function() {
                    var adID = $(this).data("adid");
                    var userID = <?=isset($_SESSION['id']) ? $_SESSION['id']: null;?>;
                    var postOwner = <?= $postOwner?>;

                    if ($(this).hasClass("btn-outline-danger")) {
                    // User already liked the ad, perform unlike action
                    unlikeAd(userID, adID);
                    } else {
                    // User hasn't liked the ad, perform like action
                    likeAd(userID, adID, postOwner);
                    }
                });
                    
                // Check if the user already liked the ads on page load
                checkIfUserLikedAd(<?=isset($_SESSION['id']) ? $_SESSION['id']: null;?>, <?=$pid?>);
                    
                });
        <?php } ?>
    </script>
</body>

</html>