<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RentalOrb - Biggest home rental service in Bangladesh</title>
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
            <?php
            // Check if the user is logged in and is an owner
            if (!isset($_SESSION['id']) || isset($_SESSION['is_owner'])) {
                redirect('index.php');
                exit();
            }

            if (isset($_SESSION['error'])) {
                if ($_SESSION['error'] == 'adsId-NotFound') {
                    alert('error', '404 - Ads Not Found!');
                    unset($_SESSION['error']);
                } elseif ($_SESSION['error'] == 'post_owner-NotMatched') {
                    alert('error', 'Unauthorized attempted to edit this ads!');
                    unset($_SESSION['error']);
                }
            }

            // Fetch rental requests for the owner
            $ownerID = $_SESSION['id'];
            $requestsQuery = "SELECT rr.id, rr.ad_id, rr.renter_id, rr.status, a.title, u.first_name, u.last_name, u.avatar, u.gander, u.policeStation, u.district, u.zipCode
                    FROM rental_requests rr
                    INNER JOIN rentalposts a ON a.id = rr.ad_id
                    INNER JOIN users u ON u.id = rr.renter_id
                    WHERE a.post_owner = $ownerID";
            $requestsResult = $con->query($requestsQuery);
            $totalRequest = $requestsResult->num_rows;

            // Fetch ad statistics
            $adsQuery = "SELECT * FROM rentalposts WHERE post_owner = $ownerID";
            $adsResult = $con->query($adsQuery);
            $totalAds = $adsResult->num_rows;

            if (!$adsResult) {
                // Display the database error
                die("Query error: " . $con->error);
            }

            // Fetch ads views
            $totalAdsViews = 0;
            $adsViewsQuery = "SELECT COUNT(*) AS total_views FROM views WHERE owner_id  = $ownerID";
            $adsViewsResult = $con->query($adsViewsQuery);
            if (!$adsViewsResult) {
                // Display the database error
                die("Query error: " . $con->error);
            }
            if ($adsViewsResult->num_rows > 0) {
                $row = $adsViewsResult->fetch_assoc();
                $totalAdsViews = $row["total_views"];
            } else {
                $totalAdsViews = 0;
            }

            // Fetch account balance
            $balanceQuery = "SELECT balance FROM users WHERE id = $ownerID";
            $balanceResult = $con->query($balanceQuery);
            $row = $balanceResult->fetch_assoc();
            $balance = $row['balance'];

            // Some account verification statistics
            $emailVerify = $isVerified > 0 ? '<i class="bi bi-envelope-at-fill text-success fs-5"></i> <span class="text-success" style="font-size: x-small;">Verified</span>' : '<i class="bi bi-envelope-at-fill text-danger fs-5"></i> <span class="text-danger" style="font-size: x-small;">Not Verified</span>';
            $nidVerify = $user_result['isVerified'] > 0 ? '<i class="bi bi-person-vcard-fill text-success fs-5"></i> <span class="text-success" style="font-size: x-small;">Verified</span>' : '<i class="bi bi-person-vcard-fill text-danger fs-5"></i> <span class="text-danger" style="font-size: x-small;">Not Verified</span>';
            ?>
            <div id="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="page-heading">
                            <div class="d-flex justify-content-start align-items-center">
                                <h3>Renter Dashboard</h3>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="#">
                                            <div class="card-body py-4 px-5">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl">
                                                        <img src="files/<?= $user_result['avatar'] ?>" alt="<?= $user_result['first_name'] . ' ' . $user_result['last_name'] ?>" />
                                                    </div>
                                                    <div class="ms-3 name">
                                                        <h5 class="font-bold"><?= $user_result['first_name'] . ' ' . $user_result['last_name'] ?></h5>
                                                        <h6 class="text-muted mb-0">
                                                            View Public Profile
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body py-4 px-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xl">
                                                    <div class="stats-icon purple mb-2" style="height: 52px; width: 52px">
                                                        <i class="iconly-boldWallet"></i>
                                                    </div>
                                                </div>
                                                <div class="ms-3 name">
                                                    <h5 class="font-bold">Balance</h5>
                                                    <h6 class="text-muted mb-0">৳<?= $balance ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body py-4 px-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xl">
                                                    <div class="stats-icon blue mb-2" style="height: 52px; width: 52px">
                                                        <i class="iconly-boldInfo-Square"></i>
                                                    </div>
                                                </div>
                                                <div class="ms-3 name">
                                                    <div class="row">
                                                        <h5 class="font-bold col-md-8">
                                                            Your Info
                                                            <span class="text-muted" style="font-size: small">(Visible to everyone)</span>
                                                        </h5>
                                                        <a href="#" class="text-info col-md-4 mb-2">
                                                            <i class="iconly-boldEdit"></i>
                                                            Update Info
                                                        </a>
                                                    </div>

                                                    <h6 class="mb-0" style="font-size: small;">
                                                        <?= $nidVerify ?>
                                                        <span class="text-muted px-2"> | </span>
                                                        <?= $emailVerify ?>
                                                        <span class="text-muted px-2"> | </span>
                                                        <i class="bi bi-geo-alt-fill text-info fs-5"></i>
                                                        <span class="text-muted fw-0" style="font-size: x-small;">
                                                            <?= $user_result['village'] . ', ' . $user_result['policeStation'] . ', ' . $user_result['district'] . '-' . $user_result['zipCode'] ?>
                                                        </span>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-content">
                            <h3>Rental Cost & Analytics</h3>
                            <section class="row">
                                <div class="col-12 col-lg-9">
                                    <div class="row">
                                        <div class="col-6 col-lg-3 col-md-6">
                                            <div class="card">
                                                <div class="card-body px-4 py-4-5">
                                                    <div class="row">
                                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                            <div class="stats-icon purple mb-2">
                                                                <i class="iconly-boldTicket"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                            <h6 class="text-muted font-semibold">Utility Bills</h6>
                                                            <h6 class="font-extrabold mb-0"><?= $totalAds ?> Ads</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-lg-3 col-md-6">
                                            <div class="card">
                                                <div class="card-body px-4 py-4-5">
                                                    <div class="row">
                                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                            <div class="stats-icon yellow mb-2">
                                                                <i class="iconly-boldDocument"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                            <h6 class="text-muted font-semibold">Monthly Rent</h6>
                                                            <h6 class="font-extrabold mb-0"><?= $totalAdsViews ?> Views</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-lg-3 col-md-6">
                                            <div class="card">
                                                <a class="card-body px-4 py-4-5" href="#requests">
                                                    <div class="row">
                                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                            <div class="stats-icon green mb-2">
                                                                <i class="iconly-boldAdd-User"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                            <h6 class="text-muted font-semibold">Requests</h6>
                                                            <h6 class="font-extrabold mb-0"><?= $totalRequest ?> Request</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6 col-lg-3 col-md-6">
                                            <div class="card">
                                                <div class="card-body px-4 py-4-5">
                                                    <div class="row">
                                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                            <div class="stats-icon blue mb-2">
                                                                <i class="iconly-boldProfile"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                            <h6 class="text-muted font-semibold">Renters</h6>
                                                            <h6 class="font-extrabold mb-0">11 Renter</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </section>
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