<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rental Orb - Privacy & Policy</title>
    <link rel="stylesheet" href="https://cdn.barikoi.com/bkoi-gl-js/dist/bkoi-gl.css">
    <script src="https://cdn.barikoi.com/bkoi-gl-js/dist/bkoi-gl.js"></script>
    <?php require('include/commonLinks.php') ?>
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

<body class="bg-light">
    <!-- Main Body -->
    <div class="container-fluid">
        <div class="row">
            <?php
            require('include/sidebar.php');
            require('include/header.php');
            // Get the ID from the query string
            $id = isset($_GET['ads']) ? $_GET['ads'] : null;
            //$id = 22;
            // Fetch data from the database
            $sql = "SELECT * FROM rentalposts WHERE id = '$id'";
            $result = $con->query($sql);
            ?>
            <div class="col-lg-10 ms-auto">
                <div class="row mt-4">
                    <?php
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $uid = $row['post_owner'];
                        $sql_u = "SELECT * FROM users WHERE id = '$uid'";
                        $result_u = $con->query($sql_u);

                        if ($result_u->num_rows > 0) {
                            $urow = $result_u->fetch_assoc();
                            // PHP code to calculate the average rating

                            $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
                            // Query to calculate the average rating
                            $query = "SELECT AVG(rating) AS average_rating FROM ratings WHERE product_id = $id"; // Replace 1 with the actual product ID
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
                            $query = "SELECT * FROM ratings WHERE product_id = $id ORDER BY id DESC"; // Replace 1 with the actual product ID
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (isset($_POST['submit'])) {
                                // Get the submitted rating and review
                                $productID = $_POST['product_id'];
                                $rating = $_POST['rating'];
                                $review = $_POST['review'];

                                // Insert the rating and review into the database
                                $date = time();
                                $query = "INSERT INTO ratings (product_id, uid, date, rating, review) VALUES (:product_id, :uid, FROM_UNIXTIME(:date), :rating, :review)";
                                $stmt = $conn->prepare($query);
                                $stmt->bindParam(':product_id', $productID);
                                $stmt->bindParam(':uid', $_SESSION['id'], PDO::PARAM_INT);
                                $stmt->bindParam(':date', $date, PDO::PARAM_INT); // Specify PDO::PARAM_INT for Unix timestamp
                                $stmt->bindParam(':rating', $rating);
                                $stmt->bindParam(':review', $review);
                                $stmt->execute();

                                $uri = $_SERVER['PHP_SELF'] . '?ads=' . $id;
                                redirect($uri);
                            }

                            $noReviw = $reviews == null ? '<h2 class="text-center text-secondary fw-bold mt-5">No Reviews Found!</h2>' : null;

                    ?>
                            <!-- Ads Details Secttion -->
                            <div class="col-md-6 col-12">
                                <div class="card mb-3">
                                    <!-- Image Slider -->
                                    <!-- <img src="..." class="card-img-top" alt="..."> -->
                                    <div id="carouselExampleFade" class="carousel slide carousel-fade">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="files/<?= $row['coverImage'] ?>" class="d-block w-100 rounded-1 h-max" alt="<?= $row['title'] ?>">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="files/<?= $row['coverImage2nd'] ?>" class="d-block w-100 rounded-1 h-max" alt="<?= $row['title'] ?>">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="files/<?= $row['coverImage3rd'] ?>" class="d-block w-100 rounded-1 h-max" alt="<?= $row['title'] ?>">
                                            </div>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $row['title'] ?></h5>
                                        <p class="card-text"><i class="bi bi-person-fill-check" style="color: #378cb5; font-weight: bold; font-size: 20px;"></i>
                                            <?= $urow['first_name'] . ' ' . $urow['last_name'] ?> |
                                            <i class="bi bi-geo-alt-fill" style="color: #e75297;"></i>
                                            <small class="text-secondary">
                                                <?= $row['street'] . ', ' . $row['area'] . ', ' . $row['policeStation'] . ', ' . $row['district'] ?>
                                            </small>
                                        </p>
                                        <p class="card-text">
                                            <i class="bi bi-patch-check-fill" style="color: #2b891f;"></i> Address Checked &bull;
                                            <i class="bi bi-check-circle-fill" style="color: #1982bf;"></i> NID Verified &bull;
                                            <i class="bi bi-envelope-check-fill" style="color: #1982bf;"></i> Email verified &bull;
                                            <i class="bi bi-check-circle-fill" style="color: #1982bf;"></i> Phone verified
                                        </p>
                                        <p class="card-text mt-5">
                                            <i class="bi bi-building" style="color: #1982bf;"></i>
                                            <span class="fw-bold text-secondary">
                                                Building Type: <span style="color: #528be1;"><?= $row['building_type'] ?></span>
                                            </span>
                                            <i class="bi bi-calendar-day" style="color: #1982bf;"></i>
                                            <span class="fw-bold text-secondary">
                                                Available Date: <i style="color: #2b891f;"><?= millsToDate($row['takeOver']) ?></i>
                                            </span>
                                            <br />
                                            <i class="bi bi-box-arrow-up-right" style="color: #1982bf;"></i>
                                            <span class="fw-bold text-secondary">
                                                <a href="https://www.google.com/maps/@<?= $geocode["latitude"]; ?>,<?= $geocode["latitude"]; ?>,18.54z?entry=ttu" target="_blank">
                                                    <span style="color: #e75297;">View in Map</span>
                                                </a>
                                            </span>
                                        </p>
                                        <p class="card-text">

                                        </p>
                                        <p class="card-text">
                                        <h5 class="text-secondary fw-bold">Ads Description</h5>
                                        <?= $row['description'] ?>
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6">
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

                                            <div class="col-md-6">
                                                <p class="card-text">
                                                <h5 class="text-secondary fw-bold">Costing &amp; Contact</h5>
                                                <?php
                                                echo '<p><span class="fw-bolder text-info fs-3">৳' . $row['cost'] . '</span><b class="fs-5 text-info-emphasis">/per Month</b></p>';
                                                echo '<p>
                                                            <a class="btn btn-outline-success btn-sm" type="button" href="#"> <i class="bi bi-plus-circle"></i> Book Now </a>
                                                            <a class="btn btn-outline-info btn-sm" type="button" href="tel:' . $row['contact'] . '"> <i class="bi bi-telephone-outbound-fill"></i> Call Owner </a>
                                                            <a class="btn btn-outline-primary btn-sm" type="button" href="mailto:' . $urow['email'] . '"> <i class="bi bi-envelope-at-fill"></i> Mail Owner </a>
                                                        </p>';
                                                echo '<p class="col-6">
                                                            <span class="fw-bold fs-5 text-secondary">Rating: </span>
                                                            <span class="badge rounded-pill bg-light">
                                                                ' . $ratingStar . '
                                                            </span>
                                                        </p>';
                                                ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="card-text">
                                                <h5 class="text-secondary fw-bold">Features</h5>
                                                <ul class="fw-bold text-opacity-75 facility-text">
                                                    <?php
                                                    $rooms = $row['rooms'] > 1 ? $row['rooms'] . ' Bedrooms' : $row['rooms'] . ' Bedroom';
                                                    $washrooms = $row['bathroom'] > 1 ? $row['bathroom'] . ' Bathrooms' : $row['bathroom'] . ' Bathroom';
                                                    $balcony = $row['balcony'] > 1 ? $row['balcony'] . ' Balconies' : $row['balcony'] . ' Balcony';
                                                    $kitchen = $row['kitchen'] == 'Yes' ? '<li>Kitchen room included</li>' : null;
                                                    $drawingRoom = $row['drawingRoom'] == 'Yes' ? '<li>Drawing Room room included</li>' : null;
                                                    echo '<li>' . $rooms . '</li>';
                                                    echo $row['bathroom'] != 0 ? '<li>' . $washrooms . '</li>' : null;
                                                    echo $row['balcony'] != 0 ? '<li>' . $balcony . '</li>' : null;
                                                    echo $kitchen;
                                                    echo $drawingRoom;
                                                    ?>
                                                </ul>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="card-text">
                                                <h5 class="text-secondary fw-bold">Terms &amp; Conditions</h5>
                                                <p class="fw-0 text-opacity-75 facility-text">
                                                    <?php
                                                    // Renter Type Family or Bachelor
                                                    if ($row['renter_type'] == 'Bachelors') {
                                                        $allowedRenters = 'Only bachelors renters &amp; ';
                                                    } else if ($row['renter_type'] == 'Families') {
                                                        $allowedRenters = 'Only family type of renters &amp; ';
                                                    } else {
                                                        $allowedRenters = 'Bachelor or family both types of renters can apply.';
                                                    }

                                                    // Allowed to apply like Male or Female
                                                    if ($row['renter_type'] == 'Male') {
                                                        $canApply = 'only male persons are allowed for apply.';
                                                    } else if ($row['renter_type'] == 'Families') {
                                                        $canApply = 'only female persons are allowed for apply.';
                                                    } else {
                                                        $canApply = 'Male or female both can apply for rent.';
                                                    }

                                                    echo $allowedRenters . ' ' . $canApply . ' Smoking, drinking, playing song louder, and how many guests are allowed at a time are negotiable.';
                                                    // Example usage:
                                                    function millisecondsToDate($milliseconds)
                                                    {
                                                        $seconds = floor($milliseconds / 1000); // Convert milliseconds to seconds
                                                        $date = DateTime::createFromFormat('U', $seconds); // Create DateTime object from seconds
                                                        return $date->format('Y-m-d H:i:s'); // Format the date as desired
                                                    }
                                                    $timestamp = strtotime(millisecondsToDate($row['date'])); // Replace with your timestamp
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
                                <h4 class="mt-3 text-center fw-bold facility-text">Similar Rentals</h4>
                                <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="files/admin/rooms/room1.jpg" class="card-img-top img-h" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Ads title</h5>
                                                <p class="card-text">
                                                    <i class="bi bi-person-fill-check" style="color: #378cb5; font-weight: bold; font-size: 20px;"></i> Username |
                                                    <i class="bi bi-building" style="color: #1982bf;"></i> <span style="color: #528be1;">Flat House</span>
                                                </p>
                                                <p class="card-text">
                                                    <i class="bi bi-geo-alt-fill" style="color: #e75297;"></i>
                                                    <small class="text-secondary">
                                                        Vogra Bypass, Chowrasta, Bason, Gazipur
                                                    </small>
                                                </p>
                                                <div class="row">
                                                    <p class="txt-center col-6"><span class="fw-bolder text-info fs-6">৳5050</span><b class="fs-6 text-info-emphasis">/per Month</b></p>
                                                    <p class="txt-center col-6"><a class="btn btn-outline-info btn-sm" type="button" href="#"> <i class="bi bi-binoculars"></i> View Details </a></p>
                                                </div>
                                                <p class="card-text">
                                                    <small class="text-body-secondary">Last update: 35 minutes ago</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="files/admin/rooms/room1.jpg" class="card-img-top img-h" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Ads title</h5>
                                                <p class="card-text">
                                                    <i class="bi bi-person-fill-check" style="color: #378cb5; font-weight: bold; font-size: 20px;"></i> Username |
                                                    <i class="bi bi-building" style="color: #1982bf;"></i> <span style="color: #528be1;">Flat House</span>
                                                </p>
                                                <p class="card-text">
                                                    <i class="bi bi-geo-alt-fill" style="color: #e75297;"></i>
                                                    <small class="text-secondary">
                                                        Vogra Bypass, Chowrasta, Bason, Gazipur
                                                    </small>
                                                </p>
                                                <div class="row">
                                                    <p class="txt-center col-6"><span class="fw-bolder text-info fs-6">৳5050</span><b class="fs-6 text-info-emphasis">/per Month</b></p>
                                                    <p class="txt-center col-6"><a class="btn btn-outline-info btn-sm" type="button" href="#"> <i class="bi bi-binoculars"></i> View Details </a></p>
                                                </div>
                                                <p class="card-text">
                                                    <small class="text-body-secondary">Last update: 6 hours ago</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="files/admin/rooms/room1.jpg" class="card-img-top img-h" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Ads title</h5>
                                                <p class="card-text">
                                                    <i class="bi bi-person-fill-check" style="color: #378cb5; font-weight: bold; font-size: 20px;"></i> Username |
                                                    <i class="bi bi-building" style="color: #1982bf;"></i> <span style="color: #528be1;">Flat House</span>
                                                </p>
                                                <p class="card-text">
                                                    <i class="bi bi-geo-alt-fill" style="color: #e75297;"></i>
                                                    <small class="text-secondary">
                                                        Vogra Bypass, Chowrasta, Bason, Gazipur
                                                    </small>
                                                </p>
                                                <div class="row">
                                                    <p class="txt-center col-6"><span class="fw-bolder text-info fs-6">৳5050</span><b class="fs-6 text-info-emphasis">/per Month</b></p>
                                                    <p class="txt-center col-6"><a class="btn btn-outline-info btn-sm" type="button" href="#"> <i class="bi bi-binoculars"></i> View Details </a></p>
                                                </div>
                                                <p class="card-text">
                                                    <small class="text-body-secondary">Last update: 1 day ago</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="files/admin/rooms/room1.jpg" class="card-img-top img-h" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Ads title</h5>
                                                <p class="card-text">
                                                    <i class="bi bi-person-fill-check" style="color: #378cb5; font-weight: bold; font-size: 20px;"></i> Username |
                                                    <i class="bi bi-building" style="color: #1982bf;"></i> <span style="color: #528be1;">Flat House</span>
                                                </p>
                                                <p class="card-text">
                                                    <i class="bi bi-geo-alt-fill" style="color: #e75297;"></i>
                                                    <small class="text-secondary">
                                                        Vogra Bypass, Chowrasta, Bason, Gazipur
                                                    </small>
                                                </p>
                                                <div class="row">
                                                    <p class="txt-center col-6"><span class="fw-bolder text-info fs-6">৳5050</span><b class="fs-6 text-info-emphasis">/per Month</b></p>
                                                    <p class="txt-center col-6"><a class="btn btn-outline-info btn-sm" type="button" href="#"> <i class="bi bi-binoculars"></i> View Details </a></p>
                                                </div>
                                                <p class="card-text">
                                                    <small class="text-body-secondary">Last update: 3 days ago</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="files/admin/rooms/room1.jpg" class="card-img-top img-h" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Ads title</h5>
                                                <p class="card-text">
                                                    <i class="bi bi-person-fill-check" style="color: #378cb5; font-weight: bold; font-size: 20px;"></i> Username |
                                                    <i class="bi bi-building" style="color: #1982bf;"></i> <span style="color: #528be1;">Flat House</span>
                                                </p>
                                                <p class="card-text">
                                                    <i class="bi bi-geo-alt-fill" style="color: #e75297;"></i>
                                                    <small class="text-secondary">
                                                        Vogra Bypass, Chowrasta, Bason, Gazipur
                                                    </small>
                                                </p>
                                                <div class="row">
                                                    <p class="txt-center col-6"><span class="fw-bolder text-info fs-6">৳5050</span><b class="fs-6 text-info-emphasis">/per Month</b></p>
                                                    <p class="txt-center col-6"><a class="btn btn-outline-info btn-sm" type="button" href="#"> <i class="bi bi-binoculars"></i> View Details </a></p>
                                                </div>
                                                <p class="card-text">
                                                    <small class="text-body-secondary">Last update: 5 days ago</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="files/admin/rooms/room1.jpg" class="card-img-top img-h" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">Ads title</h5>
                                                <p class="card-text">
                                                    <i class="bi bi-person-fill-check" style="color: #378cb5; font-weight: bold; font-size: 20px;"></i> Username |
                                                    <i class="bi bi-building" style="color: #1982bf;"></i> <span style="color: #528be1;">Flat House</span>
                                                </p>
                                                <p class="card-text">
                                                    <i class="bi bi-geo-alt-fill" style="color: #e75297;"></i>
                                                    <small class="text-secondary">
                                                        Vogra Bypass, Chowrasta, Bason, Gazipur
                                                    </small>
                                                </p>
                                                <div class="row">
                                                    <p class="txt-center col-6"><span class="fw-bolder text-info fs-6">৳5050</span><b class="fs-6 text-info-emphasis">/per Month</b></p>
                                                    <p class="txt-center col-6"><a class="btn btn-outline-info btn-sm" type="button" href="#"> <i class="bi bi-binoculars"></i> View Details </a></p>
                                                </div>
                                                <p class="card-text">
                                                    <small class="text-body-secondary">Last update: 7 days ago</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Map Section -->
                            <div class="col-md-6 col-12" style="overflow: hidden;">
                                <div id="map" class="shadow border-1"></div>

                                <!-- Review Section -->
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] . '?ads=' . $id ?>">
                                    <div class="mb-3 mt-5">
                                        <label for="comment" class="form-label facility-text fw-bold">Write a review</label>
                                        <textarea class="form-control" maxlength="240" id="comment" name="review" placeholder="Write your review" rows="5" style="resize: none;" required></textarea>
                                        <input type="hidden" name="product_id" value="<?= $id ?>">
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="mb-3 col-md-6">
                                            <div class="fs-5">
                                                <span class="fw-bold text-secondary">Select Rating: </span>
                                                <span class="star text-secondary" data-rating="1"><i class="bi bi-star-fill"></i></span>
                                                <span class="star text-secondary" data-rating="2"><i class="bi bi-star-fill"></i></span>
                                                <span class="star text-secondary" data-rating="3"><i class="bi bi-star-fill"></i></span>
                                                <span class="star text-secondary" data-rating="4"><i class="bi bi-star-fill"></i></span>
                                                <span class="star text-secondary" data-rating="5"><i class="bi bi-star-fill"></i></span>
                                                <input type="hidden" name="rating" id="rating-value" value="">
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-3 offset-md-3">
                                            <?php
                                            $login_toggle = !isset($_SESSION['id']) ? 'type="button" data-bs-toggle="modal" data-bs-target="#loginModel"' : 'type="submit" name="submit"';
                                            ?>
                                            <button <?= $login_toggle ?> class="btn btn-outline-secondary text-end"><i class="bi bi-send-plus-fill"></i> Submit Review</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- Review Comment Section -->
                                <h4 class="mt-3 fw-bold facility-text">Recent Reviews</h4>
                                <?php
                                foreach ($reviews as $review) {
                                    // Retrieve Usrname
                                    $query = "SELECT * FROM users WHERE " . $review['id'] . "";
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
                                                                <small class="text-body-secondary">Last update: ' . time_ago($review['date']) . '</small>
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
                    } else { ?>
                        <div class="row">
                            <div class="my-5 px-4">
                                <h2 class="fw-bold h-font text-center">SAVED RENTALS</h2>
                                <div class="h-line bg-dark"></div>
                                <p class="text-center mt-3">
                                    This features will be live soon. Please stay tuned.
                                </p>
                            </div>
                            <span class="align-middle" style="height: 356px;">
                                <h1 class="text-center m-auto">COMING SOON...!</h1>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Section -->
    <?php require('include/footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        bkoigl.accessToken = 'NDQ4NTpUNU5PNTBKOVZJ' // required
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
    </script>
</body>

</html>