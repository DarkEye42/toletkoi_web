<?php
    require('include/essentials.php');
    require('include/db_config.php');
    adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <?php require('include/commonLinks.php') ?>
</head>
<body class="bg-light overflow-hidden">
    
    <?php require('include/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden mt-auto">
                    <div class="content-wrapper mt-5">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                        <div class="row">
                            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                <h3 class="font-weight-bold">Welcome <?php echo $user_result["first_name"]." ".$user_result["last_name"];?></h3>
                                <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span class="text-primary">3 unread alerts!</span></h6>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                        <div class="card tale-bg">
                            <div class="card-people mt-auto">
                            <img src="images/dashboard/people.svg" alt="people">
                            <div class="weather-info">
                                <div class="d-flex">
                                <div>
                                    <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i><?=$temp;?><sup>°C</sup></h2>
                                </div>
                                <div class="ml-2">
                                    <h4 class="location font-weight-normal"><?=$city;?></h4>
                                    <h6 class="font-weight-normal"><?=$country;?></h6>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6 grid-margin transparent">
                        <div class="row">
                            <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-tale">
                                <div class="card-body">
                                <p class="mb-4">Total Site Visit</p>
                                <p class="fs-30 mb-2"><?= totalVisit(); ?></p>
                                <p>100% (Lifetime Data)</p>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-dark-blue">
                                <div class="card-body">
                                <p class="mb-4">Total Bookings</p>
                                <p class="fs-30 mb-2">61344</p>
                                <p>22.00% (30 days)</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                            <div class="card card-light-blue">
                                <div class="card-body">
                                <p class="mb-4">Number of Meetings</p>
                                <p class="fs-30 mb-2">34040</p>
                                <p>2.00% (30 days)</p>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6 stretch-card transparent">
                            <div class="card card-light-danger">
                                <div class="card-body">
                                <p class="mb-4">Number of Clients</p>
                                <p class="fs-30 mb-2">47033</p>
                                <p>0.22% (30 days)</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <p class="card-title">Order Details</p>
                            <p class="font-weight-500">The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</p>
                            <div class="d-flex flex-wrap mb-5">
                                <div class="mr-5 mt-3">
                                <p class="text-muted">Order value</p>
                                <h3 class="text-primary fs-30 font-weight-medium">12.3k</h3>
                                </div>
                                <div class="mr-5 mt-3">
                                <p class="text-muted">Orders</p>
                                <h3 class="text-primary fs-30 font-weight-medium">14k</h3>
                                </div>
                                <div class="mr-5 mt-3">
                                <p class="text-muted">Users</p>
                                <h3 class="text-primary fs-30 font-weight-medium">71.56%</h3>
                                </div>
                                <div class="mt-3">
                                <p class="text-muted">Downloads</p>
                                <h3 class="text-primary fs-30 font-weight-medium">34040</h3>
                                </div> 
                            </div>
                            <canvas id="order-chart"></canvas>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <div class="d-flex justify-content-between">
                            <p class="card-title">Sales Report</p>
                            <a href="#" class="text-info">View all</a>
                            </div>
                            <p class="font-weight-500">The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</p>
                            <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
                            <canvas id="sales-chart"></canvas>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                        <div class="card position-relative">
                            <div class="card-body">
                            <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                                <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">
                                    <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                        <div class="ml-xl-4 mt-3">
                                        <p class="card-title">Detailed Reports</p>
                                        <h1 class="text-primary">$34040</h1>
                                        <h3 class="font-weight-500 mb-xl-4 text-primary">North America</h3>
                                        <p class="mb-2 mb-xl-0">The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</p>
                                        </div>  
                                        </div>
                                    <div class="col-md-12 col-xl-9">
                                        <div class="row">
                                        <div class="col-md-6 border-right">
                                            <div class="table-responsive mb-3 mb-md-0 mt-3">
                                            <table class="table table-borderless report-table">
                                                <tr>
                                                <td class="text-muted">Illinois</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">713</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">Washington</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">583</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">Mississippi</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">924</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">California</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">664</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">Maryland</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">560</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">Alaska</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">793</h5></td>
                                                </tr>
                                            </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <canvas id="north-america-chart"></canvas>
                                            <div id="north-america-legend"></div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row">
                                    <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                        <div class="ml-xl-4 mt-3">
                                        <p class="card-title">Detailed Reports</p>
                                        <h1 class="text-primary">$34040</h1>
                                        <h3 class="font-weight-500 mb-xl-4 text-primary">North America</h3>
                                        <p class="mb-2 mb-xl-0">The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</p>
                                        </div>  
                                        </div>
                                    <div class="col-md-12 col-xl-9">
                                        <div class="row">
                                        <div class="col-md-6 border-right">
                                            <div class="table-responsive mb-3 mb-md-0 mt-3">
                                            <table class="table table-borderless report-table">
                                                <tr>
                                                <td class="text-muted">Illinois</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">713</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">Washington</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">583</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">Mississippi</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">924</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">California</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">664</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">Maryland</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">560</h5></td>
                                                </tr>
                                                <tr>
                                                <td class="text-muted">Alaska</td>
                                                <td class="w-100 px-0">
                                                    <div class="progress progress-md mx-4">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><h5 class="font-weight-bold mb-0">793</h5></td>
                                                </tr>
                                            </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <canvas id="south-america-chart"></canvas>
                                            <div id="south-america-legend"></div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                                </a>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <p class="card-title mb-0">Top Products</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    </tr>  
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Search Engine Marketing</td>
                                        <td class="font-weight-bold">$362</td>
                                        <td>21 Sep 2018</td>
                                        <td class="font-weight-medium"><div class="badge badge-success">Completed</div></td>
                                    </tr>
                                    <tr>
                                        <td>Search Engine Optimization</td>
                                        <td class="font-weight-bold">$116</td>
                                        <td>13 Jun 2018</td>
                                        <td class="font-weight-medium"><div class="badge badge-success">Completed</div></td>
                                    </tr>
                                    <tr>
                                        <td>Display Advertising</td>
                                        <td class="font-weight-bold">$551</td>
                                        <td>28 Sep 2018</td>
                                        <td class="font-weight-medium"><div class="badge badge-warning">Pending</div></td>
                                    </tr>
                                    <tr>
                                        <td>Pay Per Click Advertising</td>
                                        <td class="font-weight-bold">$523</td>
                                        <td>30 Jun 2018</td>
                                        <td class="font-weight-medium"><div class="badge badge-warning">Pending</div></td>
                                    </tr>
                                    <tr>
                                        <td>E-Mail Marketing</td>
                                        <td class="font-weight-bold">$781</td>
                                        <td>01 Nov 2018</td>
                                        <td class="font-weight-medium"><div class="badge badge-danger">Cancelled</div></td>
                                    </tr>
                                    <tr>
                                        <td>Referral Marketing</td>
                                        <td class="font-weight-bold">$283</td>
                                        <td>20 Mar 2018</td>
                                        <td class="font-weight-medium"><div class="badge badge-warning">Pending</div></td>
                                    </tr>
                                    <tr>
                                        <td>Social media marketing</td>
                                        <td class="font-weight-bold">$897</td>
                                        <td>26 Oct 2018</td>
                                        <td class="font-weight-medium"><div class="badge badge-success">Completed</div></td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-5 grid-margin stretch-card">
                            <!-- Most Visited Pages -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Most Visited Pages</h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Page</th>
                                                    <th>Visited</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?= mostVisitedPage();?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 stretch-card grid-margin">
                        <div class="card">
                            <div class="card-body">
                            <p class="card-title mb-0">Most Visited Countries</p>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                <thead>
                                    <tr>
                                    <th class="pl-0  pb-2 border-bottom">Country Name</th>
                                    <th class="border-bottom pb-2">Total Visit</th>
                                    <th class="border-bottom pb-2">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?= mostVisitedCountry(); ?>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4 stretch-card grid-margin">
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                <p class="card-title">Charts</p>
                                <div class="charts-data">
                                    <div class="mt-3">
                                    <p class="mb-0">Data 1</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="progress progress-md flex-grow-1 mr-4">
                                        <div class="progress-bar bg-inf0" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="mb-0">5k</p>
                                    </div>
                                    </div>
                                    <div class="mt-3">
                                    <p class="mb-0">Data 2</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="progress progress-md flex-grow-1 mr-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="mb-0">1k</p>
                                    </div>
                                    </div>
                                    <div class="mt-3">
                                    <p class="mb-0">Data 3</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="progress progress-md flex-grow-1 mr-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 48%" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="mb-0">992</p>
                                    </div>
                                    </div>
                                    <div class="mt-3">
                                    <p class="mb-0">Data 4</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="progress progress-md flex-grow-1 mr-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="mb-0">687</p>
                                    </div>
                                    </div>
                                </div>  
                                </div>
                            </div>
                            </div>
                            <div class="col-md-12 stretch-card grid-margin grid-margin-md-0">
                            <div class="card data-icon-card-primary">
                                <div class="card-body">
                                <p class="card-title text-white">Number of Meetings</p>                      
                                <div class="row">
                                    <div class="col-8 text-white">
                                    <h3>34040</h3>
                                    <p class="text-white font-weight-500 mb-0">The total number of sessions within the date range.It is calculated as the sum . </p>
                                    </div>
                                    <div class="col-4 background-icon">
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-3 stretch-card grid-margin">
                        <div class="card">
                            <div class="card-body">
                            <p class="card-title">Notifications</p>
                            <ul class="icon-data-list">
                                <li>
                                <div class="d-flex">
                                    <img src="images/faces/face1.jpg" alt="user">
                                    <div>
                                    <p class="text-info mb-1">Isabella Becker</p>
                                    <p class="mb-0">Sales dashboard have been created</p>
                                    <small>9:30 am</small>
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="d-flex">
                                    <img src="images/faces/face2.jpg" alt="user">
                                    <div>
                                    <p class="text-info mb-1">Adam Warren</p>
                                    <p class="mb-0">You have done a great job #TW111</p>
                                    <small>10:30 am</small>
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="d-flex">
                                <img src="images/faces/face3.jpg" alt="user">
                                <div>
                                <p class="text-info mb-1">Leonard Thornton</p>
                                <p class="mb-0">Sales dashboard have been created</p>
                                <small>11:30 am</small>
                                </div>
                                </div>
                                </li>
                                <li>
                                <div class="d-flex">
                                    <img src="images/faces/face4.jpg" alt="user">
                                    <div>
                                    <p class="text-info mb-1">George Morrison</p>
                                    <p class="mb-0">Sales dashboard have been created</p>
                                    <small>8:50 am</small>
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="d-flex">
                                    <img src="images/faces/face5.jpg" alt="user">
                                    <div>
                                    <p class="text-info mb-1">Ryan Cortez</p>
                                    <p class="mb-0">Herbs are fun and easy to grow.</p>
                                    <small>9:00 am</small>
                                    </div>
                                </div>
                                </li>
                            </ul>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <p class="card-title">Advanced Table</p>
                            <div class="row">
                                <div class="col-12">
                                <div class="table-responsive">
                                    <table id="example" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                        <th>Quote#</th>
                                        <th>Product</th>
                                        <th>Business type</th>
                                        <th>Policy holder</th>
                                        <th>Premium</th>
                                        <th>Status</th>
                                        <th>Updated at</th>
                                        <th></th>
                                        </tr>
                                    </thead>
                                </table>
                                </div>
                                </div>
                            </div>
                            </div>
                            </div>

                            
                        </div>
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. All rights reserved.</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
                        </div>
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Developed by <a href="https://www.rentalorb.com/">DarkEye IT.</a></span> 
                        </div>
                    </footer> 
                    <!-- partial -->
            </div>
        </div>
    </div>

    <?php require('../include/scripts.php') ?>
    <?php require('include/commonScripts.php') ?>
</body>
</html>