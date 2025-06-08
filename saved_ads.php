<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Saved Rentals - RentalOrb</title>
    <?php include('include/commonLinks.php') ?>
    <link rel="stylesheet" href="include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div id="app">
    <?php
        require("admin/include/db_config.php");
        require("admin/include/essentials.php");
        include('include/sidebar2.php');
    ?>

    <!-- Main Section Start -->
        <div id="main" class="layout-navbar">
            <header class="mb-3 sticky-top bg-white">
                <?php include('include/navbar.php') ?>
            </header>
            <div id="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="my-2 px-4">
                                    <h2 class="fw-bold h-font text-center">SAVED RENTALS</h2>
                                    <div class="h-line bg-dark"></div>
                                </div>
                                <div class="row row-cols-1 row-cols-md-4 g-4" style="display: contents;">
                                    <?php
                                        $userID = isset($_SESSION['id']) ? $_SESSION['id'] : null;
                                        // Pagination variables
                                        $perPage = 10; // Number of records to show per page
                                        $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1

                                        // Calculate the starting record index for the current page
                                        $startFrom = ($page - 1) * $perPage;

                                        // Retrieve liked ads data with pagination
                                        $sql = "SELECT l.*, r.* 
                                                FROM likes l
                                                INNER JOIN rentalposts r ON l.ad_id = r.id
                                                WHERE l.user_id = $userID
                                                ORDER BY l.id DESC
                                                LIMIT $startFrom, $perPage";

                                        $result = $con->query($sql);

                                        // Fetch and display the liked ads data
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $timestamp = strtotime(millsToDate($row['date'])); // Replace with your timestamp
                                                $time_ago = time_ago($timestamp);
                                                $sql_u = "SELECT * FROM users WHERE id = '" . $row['post_owner'] . "'";
                                                $result_u = $con->query($sql_u);
                                                if ($result_u->num_rows > 0) {
                                                    $urow = $result_u->fetch_assoc();
                                                    $title_m = (strlen($row['title']) > 20) ? '<marquee direction="left" scrollamount="3"><h5 class="card-title" style="margin: 0 !important;">' . $row['title'] . '</h5></marquee>' : '<h5 class="card-title">' . $row['title'] . '</h5>';
                                                    echo '<div class="col">
                                                            <div class="card h-100 shadow">
                                                                <div id="carousel' . $row['id'] . '" class="carousel slide carousel-fade">
                                                                    <div class="carousel-inner">
                                                                        <div class="carousel-item active">
                                                                        <img src="files/' . $row['coverImage'] . '" class="d-block w-100 card-img-top img-h" alt="' . $row['title'] . '">
                                                                        </div>
                                                                        <div class="carousel-item">
                                                                        <img src="files/' . $row['coverImage2nd'] . '" class="d-block w-100 card-img-top img-h" alt="' . $row['title'] . '">
                                                                        </div>
                                                                        <div class="carousel-item">
                                                                        <img src="files/' . $row['coverImage3rd'] . '" class="d-block w-100 card-img-top img-h" alt="' . $row['title'] . '">
                                                                        </div>
                                                                    </div>
                                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel' . $row['id'] . '" data-bs-slide="prev">
                                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                        <span class="visually-hidden">Previous</span>
                                                                    </button>
                                                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel' . $row['id'] . '" data-bs-slide="next">
                                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                        <span class="visually-hidden">Next</span>
                                                                    </button>
                                                                </div>
                                                                <div class="card-body">
                                                                    ' . $title_m . '
                                                                    <p class="card-text">
                                                                        <i class="bi bi-person-fill-check" style="color: #378cb5; font-weight: bold; font-size: 20px;"></i> ' . $urow['first_name'] . ' ' . $urow['last_name'] . ' |
                                                                        <i class="bi bi-building" style="color: #1982bf;"></i> <span style="color: #528be1;">' . $row['building_type'] . '</span>
                                                                    </p>
                                                                    <p class="card-text">
                                                                        <i class="bi bi-geo-alt-fill" style="color: #e75297;"></i>
                                                                        <small class="text-secondary">
                                                                            ' . $row['street'] . ', ' . $row['area'] . ', ' . $row['policeStation'] . ', ' . $row['district'] . '
                                                                        </small>
                                                                    </p>
                                                                    <div class="row">
                                                                        <p class="txt-center col-6"><span class="fw-bolder text-info fs-6">৳' . $row['cost'] . '</span><b class="fs-6 text-info-emphasis">/per Month</b></p>
                                                                        <p class="txt-center col-6"><a class="btn btn-outline-info btn-sm" type="button" href="adsDetails.php?ads=' . $row['id'] . '"> <i class="bi bi-binoculars"></i> View Details </a></p>
                                                                    </div>
                                                                    <p class="card-text">
                                                                        <small class="text-body-secondary">Last update: ' . $time_ago . '</small>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>';
                                                }
                                            }
                                        } else {
                                            echo '<div class="w-100 border border-0">
                                                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                                <lottie-player class="card-img-top" src="https://assets3.lottiefiles.com/private_files/lf30_3X1oGR.json"  background="transparent"  speed="1"  style="padding: 5px; height: 350px;"  loop  autoplay></lottie-player>
                                                <div class="card-body">
                                                    <h2 class="card-text fw-bold text-center">Here is no saved or liked ads found.</h2>
                                                </div>
                                            </div>';
                                        }
                                    ?>
                                </div>
                                    <?php
                                        // Calculate the total number of liked ads
                                        $totalQuery = "SELECT COUNT(*) AS total FROM likes WHERE user_id = $userID";
                                        $totalResult = $con->query($totalQuery);
                                        $totalRows = $totalResult->fetch_assoc()['total'];

                                        // Calculate the total number of pages
                                        $totalPages = ceil($totalRows / $perPage);

                                        // Display pagination links
                                        for ($i = 1; $i <= $totalPages; $i++) {
                                            echo "<a class='text-center' href='liked_ads.php?page=" . $i . "'> Page " . $i . "</a> ";
                                        }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    <!-- Main Section End -->
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>