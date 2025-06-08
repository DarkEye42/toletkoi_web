<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Owner Dashboard - Rental Orb</title>
    <link href="assets/css/main/datatables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="include/footer.css" />
    <?php require('include/commonLinks.php') ?>
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
                if (!isset($_SESSION['id']) || !$_SESSION['is_owner']) {
                    redirect('index.php');
                    exit();
                }

                if (isset($_SESSION['error'])){
                    if ($_SESSION['error'] == 'adsId-NotFound'){
                        alert('error', '404 - Ads Not Found!');
                        unset($_SESSION['error']);
                    } elseif ($_SESSION['error'] == 'post_owner-NotMatched'){
                        alert('error', 'Unauthorized attempted to edit this ads!');
                        unset($_SESSION['error']);
                    }
                }

                // Fetch rental requests for the owner
                $ownerID = $_SESSION['id'];
                $requestsQuery = "SELECT rr.id, rr.ad_id, rr.renter_id, rr.status, u.first_name, u.last_name, u.avatar, u.gander, u.policeStation, u.district, u.zipCode
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
                <div class="page-heading">
                    <div class="d-flex justify-content-start align-items-center">
                        <h3>Owner Dashboard</h3>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-4">
                            <div class="card">
                                <a href="#">
                                    <div class="card-body py-4 px-5">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xl">
                                                <img src="files/<?=$user_result['avatar']?>" alt="<?=$user_result['first_name'] .' '.$user_result['last_name']?>" />
                                            </div>
                                            <div class="ms-3 name">
                                                <h5 class="font-bold"><?=$user_result['first_name'] .' '.$user_result['last_name']?></h5>
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
                                            <h6 class="text-muted mb-0">৳<?=$balance?></h6>
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
                                                <a href="update-info.php" class="text-info col-md-4 mb-2">
                                                    <i class="iconly-boldEdit"></i>
                                                    Update Info
                                                </a>
                                            </div>

                                            <h6 class="mb-0" style="font-size: small;">
                                                <?=$nidVerify?>
                                                <span class="text-muted px-2"> | </span>
                                                <?=$emailVerify?>
                                                <span class="text-muted px-2"> | </span>
                                                <i class="bi bi-geo-alt-fill text-info fs-5"></i>
                                                <span class="text-muted fw-0" style="font-size: x-small;">
                                                <?=$user_result['village'].', '.$user_result['policeStation'].', '.$user_result['district'].'-'.$user_result['zipCode']?>
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
                    <h3>Ads & Renters Analytics</h3>
                    <section class="row">
                        <div class="col-12 col-lg-9">
                            <div class="row">
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldPaper"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Total Ads</h6>
                                                    <h6 class="font-extrabold mb-0"><?=$totalAds?> Ads</h6>
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
                                                        <i class="iconly-boldShow"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Ads Views</h6>
                                                    <h6 class="font-extrabold mb-0"><?=$totalAdsViews?> Views</h6>
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
                                                    <h6 class="font-extrabold mb-0"><?=$totalRequest?> Request</h6>
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
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">All Rental Ads By You</h4>
                                        </div>
                                        <div class="card-body" style="overflow: auto;">
                                        <p class="card-text" style="font-size: small;">
                                            <span class="text-primary fw-bold">Note:</span> The <code>Title</code> is the title of your ads,
                                            <code>Rate</code> is monthly cost of your room you set &amp;
                                            <code>Views</code> is the total views of your per ads.
                                        </p>
                                        <div class="card-content">
                                            <!-- Table with no outer spacing -->
                                            <div class="table-responsive">
                                                <table class="table" id="allAdsTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Rate</th>
                                                            <th>Views</th>
                                                            <th>Likes</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php while ($row = $adsResult->fetch_assoc()) { ?>
                                                        <tr>
                                                            <td class="text-bold-500">
                                                                <a class="capitalize" href="property/details/<?= $row['uniqueId']; ?>"><?= $row['category'] . ' ' . $row['building_type'] ?></a>
                                                            </td>
                                                            <td>৳<?= $row['cost']; ?></td>
                                                            <td><?= getAdsViews($row['id']); ?> Views</td>
                                                            <td><?= getTotalLikes($row['id']); ?> Likes</td>
                                                            <td>
                                                                <a href="updateAds.php?ads=<?= $row['uniqueId']; ?>" class="btn btn-sm btn-outline-primary" style="font-size: small;">
                                                                <i class="bi bi-pencil"></i> Update</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Basic Tables start -->
                                    <section class="section" id="requests">
                                        <div class="card">
                                            <h5 class="card-header">Rental Requests</h5>
                                            <div class="card-body" style="overflow: auto;">
                                                <table class="table" id="rentalRequestTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Ad Title</th>
                                                            <th>Renter</th>
                                                            <th>Gander</th>
                                                            <th>Address</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php while ($row = $requestsResult->fetch_assoc()) { ?>
                                                        <tr>
                                                            <td>
                                                                <a href="property/details/<?= $row['id'] ?>">
                                                                    <?php echo substr($row['title'], 0, 20) . "..."; ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <div class="avatar bg-warning me-3">
                                                                    <img src="files/<?= $row['avatar'] ?>" alt="<?= $row['first_name'].' '. $row['last_name']; ?>" srcset="files/<?= $row['avatar'] ?>">
                                                                </div>
                                                                <span class="fw-bold" style="text-wrap: nowrap;"><?= $row['first_name'].' '. $row['last_name']; ?></span>
                                                            </td>
                                                            <td>
                                                                <?= $row['gander'] == 'Male' ? '<i class="bi bi-gender-male text-warning"></i> '.$row['gander'] : '<i class="bi bi-gender-female text-warning"></i> '.$row['gander']; ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <span style="font-size: small;">
                                                                    <i class="bi bi-geo-alt-fill text-info fs-5"></i> 
                                                                    <?=$row['policeStation'].', '.$row['district'].'-'.$row['zipCode']?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    switch($row['status']){
                                                                        case 'accepted': echo '<span class="badge bg-success">Accepted</span>';
                                                                        break;
                                                                        case 'rejected': echo '<span class="badge bg-danger">Rejected</span>';
                                                                        break;
                                                                        case 'pending': echo '<span class="badge bg-warning">Pending</span>';
                                                                        break;
                                                                        default: echo '<span class="badge bg-danger">Cancelled</span>';
                                                                        break;
                                                                } ?>
                                                            </td>
                                                            <td>
                                                                <a href="manage_request.php?request_id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-primary" style="font-size: small;">
                                                                    <i class="bi bi-pencil"></i> Manage
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- Basic Tables end -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Latest Comments</h4>
                                        </div>
                                        <div class="card-body pb-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-lg mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Comment</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-warning me-3">
                                                                        <img src="assets/images/faces/5.jpg" alt="" srcset="">
                                                                        <span class="avatar-status bg-success"></span>
                                                                    </div>
                                                                    <p class="font-bold ms-3 mb-0">Cantik</p>
                                                                </div>
                                                            </td>
                                                            <td class="col-auto">
                                                                <p class="mb-0">
                                                                    Congratulations on your graduation!
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-warning me-3">
                                                                        <img src="assets/images/faces/2.jpg" alt="" srcset="">
                                                                        <span class="avatar-status bg-danger"></span>
                                                                    </div>
                                                                    <p class="font-bold ms-3 mb-0">Ganteng</p>
                                                                </div>
                                                            </td>
                                                            <td class="col-auto">
                                                                <p class="mb-0">
                                                                    Wow amazing design! Can you make another
                                                                    tutorial for this design?
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-warning me-3">
                                                                        <img src="assets/images/faces/1.jpg" alt="" srcset="">
                                                                        <span class="avatar-status bg-warning"></span>
                                                                    </div>
                                                                    <p class="font-bold ms-3 mb-0">Cantik</p>
                                                                </div>
                                                            </td>
                                                            <td class="col-auto">
                                                                <p class="mb-0">
                                                                    Congratulations on your graduation!
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-warning me-3">
                                                                        <img src="assets/images/faces/2.jpg" alt="" srcset="">
                                                                        <span class="avatar-status bg-danger"></span>
                                                                    </div>
                                                                    <p class="font-bold ms-3 mb-0">Ganteng</p>
                                                                </div>
                                                            </td>
                                                            <td class="col-auto">
                                                                <p class="mb-0">
                                                                    Wow amazing design! Can you make another
                                                                    tutorial for this design?
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-content">
                                            <img class="card-img-top img-fluid" src="assets/images/samples/origami.jpg" alt="Card image cap" style="height: 20rem">
                                            <div class="card-body">
                                                <h4 class="card-title">Top Image Cap</h4>
                                                <p class="card-text">
                                                    Jelly-o sesame snaps cheesecake topping. Cupcake fruitcake macaroon donut
                                                    pastry gummies tiramisu chocolate bar muffin.
                                                </p>
                                                <p class="card-text">
                                                    Cupcake fruitcake macaroon donut pastry gummies tiramisu chocolate bar muffin.
                                                </p>
                                                <button class="btn btn-primary block">Update now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Recent Messages</h4>
                                </div>
                                <div class="card-content pb-4">
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="avatar avatar-lg">
                                            <img src="assets/images/faces/4.jpg" />
                                        </div>
                                        <div class="name ms-4">
                                            <h5 class="mb-1">Hank Schrader</h5>
                                            <h6 class="text-muted mb-0">@johnducky</h6>
                                        </div>
                                    </div>
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="avatar avatar-lg">
                                            <img src="assets/images/faces/5.jpg" />
                                        </div>
                                        <div class="name ms-4">
                                            <h5 class="mb-1">Dean Winchester</h5>
                                            <h6 class="text-muted mb-0">@imdean</h6>
                                        </div>
                                    </div>
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="avatar avatar-lg">
                                            <img src="assets/images/faces/1.jpg" />
                                        </div>
                                        <div class="name ms-4">
                                            <h5 class="mb-1">John Dodol</h5>
                                            <h6 class="text-muted mb-0">@dodoljohn</h6>
                                        </div>
                                    </div>
                                    <div class="px-4">
                                        <button class="btn btn-block btn-xl btn-light-primary font-bold mt-3">
                                            Start Conversation
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Visitors Profile</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-visitors-profile"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <?php include('include/footer2.php'); ?>
        </div>
    <!-- Main Section End -->
    </div>
    
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#allAdsTable').DataTable();
            $('#rentalRequestTable').DataTable();
        });
    </script>
</body>

</html>