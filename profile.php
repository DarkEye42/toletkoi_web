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
            <div id="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 p-4 d-flex justify-content-end">
                                    <img src="files/<?=$user_result['avatar'];?>"
                                        alt="avatar"
                                        style="max-width: 220px !important; max-height: 220px !important; border-radius: 50%;"
                                        class="shadow shadow-lg">
                                </div>
                                <div class="col-lg-8 col-md-8 p-4">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="align-middle fw-normal my-auto mx-2 ">
                                            <?php echo $user_result['first_name'].' '.$user_result['last_name'];?>
                                            <i class="bi bi-patch-check-fill text-success fs-5 mx-auto" title="The given info of this user was verified by using his/her NID. Which was verified from the Bangladesh NID server."></i>
                                        </h2>
                                        <div class="button justify-content-between">
                                            <button class="btn btn-info rounded me-lg-3 my-2 text-white" style="border-radius: 50px !important;"><i class="bi bi-pencil-square"></i> Edit Profile</button>
                                            <button class="btn btn-light border border-1 border-secondary text-secondary rounded my-2" style="border-radius: 50px !important;"><i class="bi bi-eye"></i> Public View</button>
                                        </div>
                                    </div>
                                    <div class="px-2 text-muted">
                                        <i class="bi bi-geo-alt-fill fw-bold"></i>
                                        <?php echo $user_result['policeStation'].', '.$user_result['district'].'-'.$user_result['zipCode']; ?>
                                    </div>
                                    <div class="px-2 text-muted">
                                        <i class="bi bi-briefcase-fill fw-bold"></i>
                                        <?php echo $user_result['profession'].' at '.$user_result['company']; ?>
                                    </div>
                                    <div class="px-2 pt-3">
                                        <p class="text-secondary fw-normal fs-5">
                                            <?php echo $user_result['aboutMe']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-start shadow-sm border-none my-4">
                                <div class="col-lg-10 d-flex justify-content-evenly my-3">
                                    <a href="<?=$_SERVER['PHP_SELF'];?>?view=feed" class="my-auto fw-bold fs-md-5 fs-lg-5" style="border-bottom: 2px solid rgb(106, 162, 247);"><i class="bi bi-rss" title="Feed"></i> Feed</a>
                                    <a href="<?=$_SERVER['PHP_SELF'];?>?view=info" class="text-secondary my-auto fw-bold fs-md-5 fs-lg-5"><i class="bi bi-file-earmark-person" title="About"></i> About</a>
                                    <a href="<?=$_SERVER['PHP_SELF'];?>?view=contacts" class="text-secondary my-auto fw-bold fs-md-5 fs-lg-5"><i class="bi bi-people" title="Contacts"></i> Contacts</a>
                                    <a href="<?=$_SERVER['PHP_SELF'];?>?view=history" class="text-secondary my-auto fw-bold fs-md-5 fs-lg-5"><i class="bi bi-clock-history" title="History"></i> History</a>
                                </div>
                            </div>
                            <?php if((isset($_GET['view']) && $_GET['view'] == 'feed') || !isset($_GET['view'])){ ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                    if (!isset($_SESSION['userLogin']) && $_SESSION['userLogin'] != true) {
                                        redirect('index.php?error=401');
                                    }
                                        $num_per_page = 05;
                                        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
                                        $start_from = ($page - 1) * 5;

                                        // Where query if user select filer options
                                        $electricity_where = isset($_GET['electricity']) ? " AND `electricity`= 'yes'" : null;
                                        $water_where = isset($_GET['water']) ? " AND `water`= 'yes'" : null;
                                        $gas_where = isset($_GET['gas']) ? " AND `gas`= 'yes'" : null;
                                        $internet_where = isset($_GET['internet']) ? " AND `internet`= 'yes'" : null;
                                        $ac_where = isset($_GET['ac']) ? " AND `ac`= 'yes'" : null;
                                        $elevator_where = isset($_GET['elevator']) ? " AND `elevator`= 'yes'" : null;
                                        $renterType_where = isset($_GET['renterType']) ? " AND `renter_type`= '".$_GET['renterType']."'" : null;
                                        // Address query
                                        $area_where = isset($_GET['area']) && isset($_GET['area']) != null ? " AND (`street` LIKE '%".$_GET['area']."%' OR `area` LIKE '%".$_GET['area']."%')" : null;
                                        $city_where = isset($_GET['city']) && isset($_GET['city']) != null ? " AND (`policeStation` LIKE '%".$_GET['city']."%' OR `area`LIKE '%".$_GET['city']."%')" : null;
                                        // Date query
                                        $date_where = isset($_GET['date']) && isset($_GET['date']) != null ? " AND `takeOver` >= '".(strtotime($_GET['date']) * 1000)."'" : null;

                                        $sql_q = "SELECT * FROM `rentalposts` WHERE `post_owner` = ".$_SESSION['id']." ".$renterType_where." ".$electricity_where." ".$water_where."
                                        ".$gas_where." ".$internet_where." ".$ac_where." ".$elevator_where." ".$date_where." ".$area_where." ".$city_where."
                                        ORDER BY `rentalposts`.`date` DESC LIMIT $start_from, $num_per_page";
                                        $conn = mysqli_query($con, $sql_q);
                                        $num_row = mysqli_num_rows($conn);

                                        if($num_row>0){
                                            while($data = mysqli_fetch_assoc($conn)){
                                                $electricity_q = ($data['electricity'] > 0) ? '<span class="badge text-bg-light text-wrap"> Electricity </span>' : '';
                                                $water_q = ($data['water'] > 0) ? '<span class="badge text-bg-light text-wrap"> Water </span>' : '';
                                                $gas_q = ($data['gas'] > 0) ? '<span class="badge text-bg-light text-wrap"> Gas </span>' : '';
                                                $internet_q = ($data['internet'] > 0) ? '<span class="badge text-bg-light text-wrap"> Internet </span>' : '';
                                                $ac_q = ($data['ac'] > 0) ? '<span class="badge text-bg-light text-wrap"> Air Condition </span>' : '';
                                                $elevator_q = ($data['elevator'] > 0) ? '<span class="badge text-bg-light text-wrap"> Elevator </span>' : '';
                                                $address_q = ($data['street'] != null) ? $data['street'].', '.$data['area'].', '.$data['policeStation'].', '.$data['district'] : '';
                                                $public_view = ($data['post_owner'] != $_SESSION['id']) ? '<h6 class="mb-4 text-success fw-bold">'.$data['cost'].'৳ per Month</h6>' : '<h6 class="mb-4 text-success fw-bold">'.$data['cost'].'৳ per Month</h6><p class="py-1 border border-1 border-secondary text-muted" style="border-radius: 50px !important;"><i class="bi bi-eye-fill fw-bold"></i> Public View</p>';
                                                $title_q = (strlen($data['title']) > 35) ? '<marquee direction="left" scrollamount="3"><h5 style="margin: 0 !important;">'.$data['title'].'</h5></marquee>' : '<h5>'.$data['title'].'</h5>';
                                                $randomToken = randomString(50);
                                                echo <<<recent_ads
                                                    <div class="card mb-4 border-0 rounded shadow">
                                                        <div class="row g-0 p-3 align-items-center">
                                                            <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                                                <img src="files/{$data['coverImage']}" class="img-fluid center-cropped rounded" style="height: 280px !important;">
                                                            </div>
                                                            <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                                                {$title_q}
                                    
                                                                <div class="features mb-3">
                                                                    <h6 class="mb-1">Features</h6>
                                                                    <span class="badge text-bg-light text-wrap">
                                                                        {$data['rooms']} Rooms
                                                                    </span>
                                                                    <span class="badge text-bg-light text-wrap">
                                                                        2 Attatched Bathroom
                                                                    </span>
                                                                    <span class="badge text-bg-light text-wrap">
                                                                        2 Balconys
                                                                    </span>
                                                                    <span class="badge text-bg-light text-wrap">
                                                                        1 Kitchen
                                                                    </span>
                                                                    <span class="badge text-bg-light text-wrap">
                                                                        1 Drawing Room
                                                                    </span>  
                                                                </div>
                                    
                                                                <div class="facilities mb-3">
                                                                    <h6 class="mb-1">Facilities</h6>
                                                                    {$electricity_q}
                                                                    {$water_q}
                                                                    {$gas_q}
                                                                    {$internet_q}
                                                                    {$ac_q}
                                                                    {$elevator_q}
                                                                </div>

                                                                <div class="location">
                                                                    <h6 class="mb-1">Location</h6>
                                                                    <span class="badge text-bg-light text-wrap"><i class="bi bi-geo-alt-fill fw-bold" style="font-size: 15px;"></i> {$address_q} </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                                                                {$public_view}
                                                                <a href="adsDetails.php?ads={$data['id']}&refer=profile&token={$randomToken}" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">More Details</a>
                                                                <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">Ads Settings</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    recent_ads;
                                            }
                                            $sql_q_page = "SELECT * FROM `rentalposts` WHERE `post_owner` = ".$_SESSION['id']." ".$renterType_where." ".$electricity_where." ".$water_where."
                                            ".$gas_where." ".$internet_where." ".$ac_where." ".$elevator_where." ".$date_where." ".$area_where." ".$city_where."
                                            ORDER BY `rentalposts`.`date` DESC";
                                            $conn_page = mysqli_query($con, $sql_q_page);
                                            $num_row_page = mysqli_num_rows($conn_page);
                                            $total_pages = ceil($num_row_page/$num_per_page);
                                            ?>
                                            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-center">
                                                    
                                                        <?php
                                                            if (isset($_GET['filter'])) {
                                                                if (isset($_GET['page']) == $page - 1) {
                                                                    $url = new URL($_SERVER['HTTP_REFERER']);
                                                                    $url->remove_param('page');
                                                                } elseif (isset($_GET['page']) == $page + 1) {
                                                                    $url = new URL($_SERVER['HTTP_REFERER']);
                                                                    $url->remove_param('page');
                                                                } elseif (isset($_GET['page']) == $page) {
                                                                    $url = new URL($_SERVER['HTTP_REFERER']);
                                                                } else {
                                                                    $url = new URL($_SERVER['HTTP_REFERER']);
                                                                }
                                                            }
                                                            if (isset($_GET['submit'])) {
                                                                $url = new URL("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                                                                $url->remove_param('submit');
                                                                $url->redirect();
                                                            }

                                                            if($page > 1){
                                                                $uri_p = (isset($_GET['filter'])) ? $url->url.'&page='.$page - 1 : $_SERVER['PHP_SELF'].'?page='.$page - 1;
                                                                echo '<li class="page-item">
                                                                        <a href="'.$uri_p.'" class="page-link"><span aria-hidden="true">&laquo;</span> Previous</a>
                                                                    </li>';
                                                            } else {
                                                                echo '<li class="page-item disabled">
                                                                        <a class="page-link"><span aria-hidden="true">&laquo;</span> Previous</a>
                                                                    </li>';
                                                            }
                                                        ?>
                                                    <?php
                                                        for($i = 1; $i <= $total_pages; $i++){
                                                            if (isset($_GET['filter'])){
                                                                if(isset($_GET['page']) == $i-1){
                                                                    $url = new URL($_SERVER['HTTP_REFERER']);
                                                                    $url->remove_param('page');
                                                                } elseif(isset($_GET['page']) == $i+1){
                                                                    $url = new URL($_SERVER['HTTP_REFERER']);
                                                                    $url->remove_param('page');
                                                                } elseif(isset($_GET['page']) == $i){
                                                                    $url = new URL($_SERVER['HTTP_REFERER']);
                                                                } else {
                                                                    $url = new URL($_SERVER['HTTP_REFERER']);
                                                                }
                                                            }

                                                            $uri_filter = (isset($_GET['filter'])) ? $url->url.'&page='.$i : $_SERVER['PHP_SELF'].'?page='.$i;
                                                            echo ($page == $i) ? '<li class="page-item active"><a class="page-link">'.$i.'</a></li>' : '<li class="page-item"><a href="'.$uri_filter.'" class="page-link">'.$i.'</a></li>';
                                                        }
                                                    ?>
                                                    <li class="page-item">
                                                    <a class="page-link <?php echo (ceil($num_row_page / $num_per_page) == $page) ? "disabled" : "" ;?>"
                                                        href="<?php echo (isset($_GET['filter'])) ? $url->url.'&page='.$page + 1 : $_SERVER['PHP_SELF'].'?page='.$page + 1;?>">Next <span aria-hidden="true">&raquo;</span></a>
                                                    </li>
                                                </ul>
                                            </nav>
                                    <?php
                                        } else {
                                    ?>
                                    <div class="card w-100 shadow border border-0">
                                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                        <lottie-player class="card-img-top" src="https://assets3.lottiefiles.com/private_files/lf30_3X1oGR.json"  background="transparent"  speed="1"  style="padding: 5px; height: 350px;"  loop  autoplay></lottie-player>
                                        <div class="card-body">
                                            <h2 class="card-text fw-bold text-center">Here are no matched rental ads with your filtered data.</h2>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                            </div>
                            </div>
                            <?php } elseif(isset($_GET['view']) && $_GET['view'] == 'info'){ ?>
                                <div class="row">
                                    <div class="col-8 d-flex justify-content-between card card-bg-white rounded shadow-sm ms-3 border-0">
                                        <div class="col-lg-10 col-md-10 mx-lg-3 mx-md-1 p-2">
                                            <p class="text-secondary fw-bold my-3">Personal Info</p>
                                            <div class="d-flex justify-content-start text-secondary">
                                                <i class="bi bi-gender-ambiguous fw-bold"></i>
                                                <p class="text-secondary"><span class="fw-bold ms-1 me-2"> Gender:</span> <?=  $user_result['gander']?></p>
                                            </div>
                                            <div class="d-flex justify-content-start text-secondary">
                                                <i class="bi bi-person-vcard-fill"></i>
                                                <p class="text-secondary"><span class="fw-bold ms-1 me-2"> NID Number:</span> <?=  $user_result['nidNumber']?> <span class="text-success fw-bold" style="font-size: smaller;">(Verified)</span></p>
                                            </div>
                                            <div class="d-flex justify-content-start text-secondary">
                                                <i class="bi bi-calendar-date-fill"></i>
                                                <p class="text-secondary"><span class="fw-bold ms-1 me-2"> Birth Date:</span> <?=  date("jS M Y", ceil($user_result['birthDate']/1000))?></p>
                                            </div>
                                            <div class="d-flex justify-content-start text-secondary">
                                                <i class="bi bi-calendar2-check-fill"></i>
                                                <p class="text-secondary"><span class="fw-bold ms-1 me-2"> Join Date:</span> <?=  date("jS M Y", ceil($user_result['joinDate']/1000))?></p>
                                            </div>
                                            <p class="text-secondary fw-bold my-3">Contact Details</p>
                                            <div class="d-flex justify-content-start text-secondary">
                                                <i class="bi bi-envelope-at-fill me-3"></i>
                                                <p class="text-secondary"><?=$user_result['email']?></p>
                                            </div>
                                            <div class="d-flex justify-content-start text-secondary">
                                                <i class="bi bi-telephone-fill me-3"></i>
                                                <p class="text-secondary"><?=$user_result['phone']?></p>
                                            </div>
                                            <div class="d-flex justify-content-start text-secondary">
                                                <i class="bi bi-geo-alt-fill me-3"></i>
                                                <p class="text-secondary"><?=$user_result['village'].', '.$user_result['policeStation'].', '.$user_result['district'].', '.$user_result['division'].'-'.$user_result['zipCode']?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <h3 class="text-secondary fw-bold text-center">No Contacts Found</h3>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
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