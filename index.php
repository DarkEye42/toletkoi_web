<?php require("admin/include/db_config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ToletKoi - বাসা ভাড়া খুঁজুন বা দিন যখন তখন একদম ফ্রী</title>
    <meta name="robots" content="index, follow">
    <meta name="description" content="ঘরে বসে বাসা ভাড়া খুঁজুন এবং ভাড়া দিন যখন তখন অনলাইনে একদম ফ্রী। ফ্যামিলি বাসা বা ব্যাচেলর বাসা, ১ রুম বা ২ রুমের বাসা আর হোক না বড় বা ছোট বাসা সকল প্রকার বাসা খুঁজুন খুব সহজেই।">
    <meta name="keywords" content="বাসা ভাড়া, বাসা ভাড়া ঢাকা, বাসা ভাড়া টুলেটকই, ১ রুমের বাসা, ছোট বাসা, ফ্যামিলি বাসা, ব্যাচেলর বাসা, অফিস ভাড়া ঢাকা, অফিস ভাড়া টুলেটকই, আবাসিক বা অফিস ভাড়া, প্রযুক্তি শহরে বাসা ভাড়া, বাসা ভাড়া উত্তরা, বাসা ভাড়া গুলশান, বাসা ভাড়া বনানী, বাসা ভাড়া দানমন্ডি, বাসা ভাড়া মিরপুর, বাসা ভাড়া মোহাম্মদপুর, বাসা ভাড়া ফার্মগেট, বাসা ভাড়া শ্যামপুর, বাসা ভাড়া মতিঝিল, house for rent, house for rent in Dhaka, house for rent Toletkoi, 1 room house, small house for rent, family house for rent, bachelor house for rent, office for rent in Dhaka, office for rent Toletkoi, residential or office rental, tech city house for rent, house for rent Uttara, house for rent Gulshan, house for rent Banani, house for rent Dhanmondi, house for rent Mirpur, house for rent Mohammadpur, house for rent Farmgate, house for rent Shyamoli, house for rent Motijheel">
    <?php include('include/commonLinks.php') ?>
    <link rel="stylesheet" href="include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div id="app">
        <?php
        require("admin/include/essentials.php");
        include('include/sidebar2.php');
        // Check if the user viewed ads
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];
            $checkViewQuery = "SELECT r.* , v.time
                        FROM rentalposts r
                        JOIN views v ON r.id = v.ads_id
                        WHERE v.user_id = $userId
                        ORDER BY v.time DESC
                        LIMIT 9";
            $viewsResult = $con->query($checkViewQuery);
        }

        // Success & Error Alerts Start

        if (isset($_SESSION['error'])) {
            if ($_SESSION['error'] == 'NotLoggedIn') {
                alert('error', 'Please login to access this page!');
                unset($_SESSION['error']);
            } elseif ($_SESSION['error'] == '401') {
                alert('error', 'You are not authorized to edit this ads!');
                unset($_SESSION['error']);
            }
        }

        if (isset($_SESSION['post'])) {
            if ($_SESSION['post'] == 'success') {
                alert('success', 'Congratulations! Ads successfully posted.');
                unset($_SESSION['post']);
            } elseif ($_SESSION['post'] == 'error') {
                alert('error', 'Sorry! Ads not posted.');
                unset($_SESSION['post']);
            }
        }

        if (isset($_SESSION["login_page"]) && $_SESSION["login_page"] == 'denied') {
            alert("error", "You are already logged in so you can't view this page!");
            unset($_SESSION["login_page"]);
        }

        if (isset($_SESSION["verify"]) && $_SESSION["verify"] == 'success') {
            alert("success", "Your email has been verified successfully. Please login to continue.");
            unset($_SESSION["verify"]);
        } else if (isset($_SESSION["verify"]) && $_SESSION["verify"] == 'failed') {
            alert("error", "Verification token has been expired or invalid. Please try again!");
            unset($_SESSION["verify"]);
        }

        if (isset($_SESSION["verify_token"]) && $_SESSION["verify_token"] == '404') {
            alert("error", "Invalid verification token. Please try again");
            unset($_SESSION["verify_token"]);
        }

        if (isset($_SESSION["verify"]) && $_SESSION["verify"] == 'incomplete') {
            alert("error", "Please verify your email first and try again!");
            unset($_SESSION["verify"]);
        }

        if (isset($_SESSION["register"]) && $_SESSION["register"] == 'success') {
            alert('success', 'Registration successful. Please check your email for verification.');
            unset($_SESSION["verify"]);
        }

        if (isset($_SESSION["updateInfo"]) && $_SESSION['updateInfo'] == true) {
            alert('success', 'Congratulations! Your information updated successfully.');
            unset($_SESSION["updateInfo"]);
        }

        // Success & Error Alerts End

        ?>
        <!-- Main Section Start -->
        <div id="main" class="layout-navbar">
            <header class="mb-3 sticky-top bg-white">
                <?php include('include/navbar.php') ?>
            </header>
            <div id="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">

                            <!-- Rentals Search Section Start -->
                            <div class="shadow rounded col-lg-12 p-4 overflow-hidden bg-white">
                                <h5 class="modal-title fs-5 d-flex align-items-center">
                                    <i class="iconly-boldSearch me-1 fs-4"></i> Search For Rentals
                                </h5>
                                <div class="row g-3">
                                    <!-- Categories Section Start -->

                                    <section class="col-lg-3 col-md-4 col-12" id="category">
                                        <div class="row row-cols-3 g-1">
                                            <div class="col">
                                                <input type="radio" name="propertyType" value="Family" class="radio_input" id="family" checked>
                                                <label class="radio_label_2 w-100" for="family">
                                                    Family
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="propertyType" value="Bachelor" class="radio_input" id="bachelor">
                                                <label class="radio_label_2 w-100" for="bachelor">
                                                    Bachelor
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="propertyType" value="Sublet" class="radio_input" id="sublet">
                                                <label class="radio_label_2 w-100" for="sublet">
                                                    Sublet
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="propertyType" value="Office" class="radio_input" id="office">
                                                <label class="radio_label_2 w-100" for="office">
                                                    Office
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="propertyType" value="Hostel" class="radio_input" id="hostel">
                                                <label class="radio_label_2 w-100" for="hostel">
                                                    Hostel
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="propertyType" value="Shop" class="radio_input" id="shop">
                                                <label class="radio_label_2 w-100" for="shop">
                                                    Shop
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="propertyType" value="Factory Place" class="radio_input" id="factory">
                                                <label class="radio_label_2 w-100" for="factory">
                                                    Factory
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="propertyType" value="Ready Shed" class="radio_input" id="shed">
                                                <label class="radio_label_2 w-100" for="shed">
                                                    Shed
                                                </label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="propertyType" value="Land" class="radio_input" id="land">
                                                <label class="radio_label_2 w-100" for="land">
                                                    Land
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Categories Section End -->
                                    <section class="col-lg-9 col-md-8 col-12 mt-md-3">
                                        <div class="row g-1">
                                            <div class="row row-cols-1 row-cols-md-3 g-1">
                                                <div class="form-floating col">
                                                    <select class="form-select" name="division" id="division" required>
                                                        <option value="">Select Division</option>
                                                        <?php echo load_division(); ?>
                                                    </select>
                                                    <label for="division" style="left: unset;">Division</label>
                                                </div>

                                                <div class="form-floating col">
                                                    <select class="form-select" name="district" id="district" required>
                                                        <option value="">Select District</option>
                                                    </select>
                                                    <label for="division" style="left: unset;">District</label>
                                                </div>

                                                <div class="form-floating col">
                                                    <select class="form-select" name="area" id="area" required>
                                                        <option value="">Select Thana</option>
                                                    </select>
                                                    <label for="area" style="left: unset;">Thana</label>
                                                </div>
                                            </div>
                                            <div class="clo-12 mt-2 px-3 justify-content-center d-flex">
                                                <a id="searchBtn" href="#" class="btn btn-sm btn-outline-primary w-75">Search Rental</a>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <span id="thanaHtml"></span>

                            </div>
                            <!-- Rentals Search Section End -->

                            <!-- Rental Ads Start -->
                            <div class="container">
                                <div class="row">
                                    <h5 class="col-12 mt-3 fw-bold text-center facility-text">Recently Posted Rentals</h5>
                                    <!-- Bachelor Ads Section Start -->
                                    <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                                        <h6 class="mt-3 fw-bold facility-text">Bachelor Rentals</h6>
                                        <a href="explore/category/Bachelor" class="align-items-center">
                                            <span class="fw-bold fs-6">
                                                See More <i class="bi bi-caret-right-fill fw-bold fs-5"></i>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="row g-2 mt-0">

                                        <?php
                                        $bachelorPosts = getCategoryPosts('bachelor');

                                        if ($bachelorPosts) {
                                            foreach ($bachelorPosts as $row) {
                                                echo '<div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 mb-n30px">
                                                            <div class="card shadow">
                                                                <div id="carousel' . $row['uniqueId'] . '" class="carousel slide">
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
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="next">
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
                                    <!-- Bachelor Ads Section End -->

                                    <!-- Family Ads Section Start -->
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <h6 class="mt-3 fw-bold facility-text">Family Rentals</h6>
                                        <a href="explore/category/Family" class="align-items-center"><span class="fw-bold fs-6">See More <i class="bi bi-caret-right-fill fw-bold fs-5"></i></span></a>
                                    </div>
                                    <div class="row g-2 mt-0">


                                        <?php
                                        $bachelorPosts = getCategoryPosts('family');

                                        if ($bachelorPosts) {
                                            foreach ($bachelorPosts as $row) {
                                                echo '<div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 mb-n30px">
                                                            <div class="card shadow">
                                                                <div id="carousel' . $row['uniqueId'] . '" class="carousel slide">
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
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="next">
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
                                    <!-- Family Ads Section End -->

                                    <!-- Office Ads Section Start -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mt-3 fw-bold facility-text">Office Rentals</h6>
                                        <a href="explore/category/Office" class="align-items-center"><span class="fw-bold fs-6">See More <i class="bi bi-caret-right-fill fw-bold fs-5"></i></span></a>
                                    </div>
                                    <div class="row g-2 mt-0">


                                        <?php
                                        $bachelorPosts = getCategoryPosts('office');

                                        if ($bachelorPosts) {
                                            foreach ($bachelorPosts as $row) {
                                                echo '<div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 mb-n30px">
                                                            <div class="card shadow">
                                                                <div id="carousel' . $row['uniqueId'] . '" class="carousel slide">
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
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="next">
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
                                    <!-- Office Ads Section End -->

                                    <!-- Sublet Ads Section Start -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mt-3 fw-bold facility-text">Sublet Rentals</h6>
                                        <a href="explore/category/Sublet" class="align-items-center"><span class="fw-bold fs-6">See More <i class="bi bi-caret-right-fill fw-bold fs-5"></i></span></a>
                                    </div>
                                    <div class="row g-2 mt-0">


                                        <?php
                                        $bachelorPosts = getCategoryPosts('sublet');

                                        if ($bachelorPosts) {
                                            foreach ($bachelorPosts as $row) {
                                                echo '<div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 mb-n30px">
                                                            <div class="card shadow">
                                                                <div id="carousel' . $row['uniqueId'] . '" class="carousel slide">
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
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="next">
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
                                    <!-- Sublet Ads Section End -->

                                    <!-- Hostel Ads Section Start -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mt-3 fw-bold facility-text">Hostel Rentals</h6>
                                        <a href="explore/category/Hostel" class="align-items-center"><span class="fw-bold fs-6">See More <i class="bi bi-caret-right-fill fw-bold fs-5"></i></span></a>
                                    </div>
                                    <div class="row g-2 mt-0">


                                        <?php
                                        $bachelorPosts = getCategoryPosts('hostel');

                                        if ($bachelorPosts) {
                                            foreach ($bachelorPosts as $row) {
                                                echo '<div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 mb-n30px">
                                                            <div class="card shadow">
                                                                <div id="carousel' . $row['uniqueId'] . '" class="carousel slide">
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
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel' . $row['uniqueId'] . '" data-bs-slide="next">
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
                                    <!-- Hostel Ads Section End -->

                                </div>
                            </div>
                            <!-- Rental Ads End -->

                            <!-- Download Apps Section Start -->
                            <div class="container pb-2 mt-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-md card-borderless">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <h3 class="h1">Download our apps</h3>
                                                        <div class="markdown text-muted">
                                                            Our mobile application will be available for everyone.
                                                            <br> We are working hard to develop our mobile application.
                                                            <br> Thank you.
                                                            <br> ToletKoi Team.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="my-3">
                                                            <a href="#" target="_blank" rel="noopener">
                                                                <img src="files/downloadApp.png" alt="" srcset="files/googlePlay.png" loading="lazy" style="max-width: 250px; height: 76px;">
                                                            </a>
                                                            <a href="#" target="_blank" rel="noopener">
                                                                <img src="files/downloadApp.png" alt="" srcset="files/appStore.png" loading="lazy" style="max-width: 250px; height: 80px;">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Download Apps Section End -->

                        </div>
                        <?php if (!isset($_SESSION['id'])) { ?>
                            <div class="col-lg-3">
                                <div class="card border-0 p-2 rounded shadow-sm" style="position: fixed; margin-right: 2rem;">
                                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                    <div class="d-flex justify-content-center">
                                        <lottie-player src="https://assets2.lottiefiles.com/private_files/lf30_u4mgmpw4.json" background="transparent" speed="1" style="max-width: 30%; max-height: 180px" loop autoplay></lottie-player>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <h3>Upgrade to <span class="fw-bold text-info">Pro</span></h3>
                                    </div>
                                    <div class="text-center text-secondary">
                                        <p>In premium features you can access all the special services. You can promote your rental ads & have unlimited posting advantage.</p>
                                    </div>
                                    <div class="mx-2" style="font-size: smaller">
                                        <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Unlimited Ads Post.</p>
                                        <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Get Verified Renters or Ads.</p>
                                        <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Verified Nareby Location Access.</p>
                                        <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Get 10 Free Ads Boots per Month.</p>
                                        <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Get Access of Rental Police From.</p>
                                        <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> 24/7 Premium Customer Support.</p>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-info rounded me-lg-3 my-2 text-light" style="border-radius: 50px !important;">Upgrade Now</button>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-3">
                                <?php if ($viewsResult->num_rows > 0) { ?>
                                    <div class="recent-activities card">
                                        <div class="card-header">
                                            <h3 class="h4"><i class="bi bi-clock-fill fs-4"></i> Recently Viewed Ads</h3>
                                        </div>
                                        <div class="card-body no-padding">
                                            <div class="row">
                                                <?php
                                                // Counter to track the number of rows
                                                $rowCounter = 0;
                                                while ($row = $viewsResult->fetch_assoc()) {
                                                    $rowCounter++;
                                                    // Convert date to milliseconds
                                                    $milliseconds = strtotime($row['time']);

                                                    // Show an ad after every 3 data rows (adjust the number as needed)
                                                    if ($rowCounter % 4 == 0) {
                                                        // Insert your Google Ads code here
                                                        echo '<div class="col-6">
                                                            <div class="card mb-3 border-0 shadow" style="max-height: 340px !important;">
                                                                <div class="card-body">
                                                                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7549719830059811"
                                                                            crossorigin="anonymous"></script>
                                                                    <!-- Recently Viewed Ads Area -->
                                                                    <ins class="adsbygoogle"
                                                                            style="display:block"
                                                                            data-ad-client="ca-pub-7549719830059811"
                                                                            data-ad-slot="6758227574"
                                                                            data-ad-format="auto"
                                                                            data-full-width-responsive="true"></ins>
                                                                    <script>
                                                                            (adsbygoogle = window.adsbygoogle || []).push({});
                                                                    </script>
                                                                </div>
                                                            </div>
                                                        </div>';
                                                    }
                                                ?>
                                                    <div class="col-6">
                                                        <div class="card mb-3 border-0 shadow">
                                                            <div id="recentViewCarousel<?= $row['uniqueId']; ?>" class="carousel slide">
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
                                                                <button class="carousel-control-prev" type="button" data-bs-target="#recentViewCarousel<?= $row['uniqueId']; ?>" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button" data-bs-target="#recentViewCarousel<?= $row['uniqueId']; ?>" data-bs-slide="next">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Next</span>
                                                                </button>
                                                            </div>
                                                            <a href="property/details/<?= $row['uniqueId'] ?>">
                                                                <div class="card-body p-1">
                                                                    <p class="card-text mb-0">
                                                                        <i class="bi bi-geo-alt-fill" style="color: #e75297; font-size: 14px;"></i>
                                                                        <small class="text-secondary" style="font-size: 10px;">
                                                                            <?= $row['policeStation'] . ', ' . $row['district'] ?>
                                                                        </small>
                                                                    </p>
                                                                    <p class="card-text text-end">
                                                                        <i class="bi bi-eye-fill" style="font-size: 14px;"></i> <small class="text-body-secondary" style="font-size: 11px;"> <?= time_ago($milliseconds) ?></small>
                                                                    </p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                <?php } else { ?>
                                    <div class="card border-0 p-2 rounded shadow-sm" style="position: fixed; margin-right: 2rem;">
                                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                        <div class="d-flex justify-content-center">
                                            <lottie-player src="https://assets2.lottiefiles.com/private_files/lf30_u4mgmpw4.json" background="transparent" speed="1" style="max-width: 30%; max-height: 180px" loop autoplay></lottie-player>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <h3>Upgrade to <span class="fw-bold text-info">Pro</span></h3>
                                        </div>
                                        <div class="text-center text-secondary">
                                            <p>In premium features you can access all the special services. You can promote your rental ads & have unlimited posting advantage.</p>
                                        </div>
                                        <div class="mx-2" style="font-size: smaller">
                                            <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Unlimited Ads Post.</p>
                                            <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Get Verified Renters or Ads.</p>
                                            <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Verified Nareby Location Access.</p>
                                            <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Get 10 Free Ads Boots per Month.</p>
                                            <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Get Access of Rental Police From.</p>
                                            <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> 24/7 Premium Customer Support.</p>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-info rounded me-lg-3 my-2 text-light" style="border-radius: 50px !important;">Upgrade Now</button>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
        <!-- Main Section End -->
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/essential.js"></script>
</body>

</html>