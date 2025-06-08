<?php
    require("admin/include/db_config.php");
    require("admin/include/essentials.php");
    include('include/sidebar2.php');
?>
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
    <!-- Main Section Start -->
        <div id="main" class="layout-navbar">
            <header class="mb-3 sticky-top bg-white">
                <?php include('include/navbar.php') ?>
            </header>
            <div id="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="my-3 px-4">
                            <h4 class="fw-bold h-font text-center">AVAILABLE RENTALS</h4>
                            <div class="h-line bg-dark"></div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                        <?php
                                            $num_per_page = 24;
                                            $page = (isset($_GET['page']) ? $_GET['page'] : 1);
                                            $start_from = ($page - 1) * 24;

                                            // Address query
                                            $city_where = isset($_GET['area']) && isset($_GET['area']) != null ? " AND `policeStation` = '" . str_replace('-', ' ', $_GET['area']) . "'" : "";
                                            // Category query
                                            $cat_where = isset($_GET['category']) ? " AND `category` = '" . str_replace('-', ' ', $_GET['category']) . "'" : "";

                                            $sql_q = "SELECT * FROM `rentalposts` WHERE `active` = 1 ".$city_where." ".$cat_where."
                                            ORDER BY `rentalposts`.`date` DESC LIMIT $start_from, $num_per_page";

                                            // Number of results query
                                            $sql_q_results = "SELECT * FROM `rentalposts` WHERE `active` = 1 ".$city_where." ".$cat_where."
                                            ORDER BY `rentalposts`.`date` DESC";
                                            
                                            $conn_res = mysqli_query($con, $sql_q_results);
                                            $num_res = mysqli_num_rows($conn_res);

                                            $conn = mysqli_query($con, $sql_q);
                                            $num_row = mysqli_num_rows($conn);

                                            if($num_row>0){
                                            ?>
                                            
                                            
                                            <span class="badge bg-light-primary text-wrap mb-3">
                                                Total <?=$num_res?> rental ads found
                                            </span>
                                            <div class="row g-2 mt-0">
                                            <?php
                                                while($row = mysqli_fetch_assoc($conn)){
                                            echo '<div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2">
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
                                                

                                                $sql_q_page = "SELECT * FROM `rentalposts` WHERE `active` = 1 ".$city_where." ".$cat_where."
                                                ORDER BY `rentalposts`.`date` DESC";
                                                $conn_page = mysqli_query($con, $sql_q_page);
                                                $num_row_page = mysqli_num_rows($conn_page);
                                                $total_pages = ceil($num_row_page/$num_per_page);
                                                ?>
                                                </div>
                                                <h6 class="fw-bold h-font text-center"></h6>
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-start">
                                                        
                                                            <?php
                                                                $page_plus = $page + number_format(1);
                                                                $page_minus = $page - number_format(1);
                                                                if (isset($_GET['filter'])) {
                                                                    if (isset($_GET['page']) == $page-1) {
                                                                        $url = new URL($_SERVER['HTTP_REFERER']);
                                                                        $url->remove_param('page');
                                                                    } elseif (isset($_GET['page']) == $page+1) {
                                                                        $url = new URL($_SERVER['HTTP_REFERER']);
                                                                        $url->remove_param('page');
                                                                    } elseif (isset($_GET['page']) == $page) {
                                                                        $url = new URL($_SERVER['HTTP_REFERER']);
                                                                    } else {
                                                                        $url = new URL($_SERVER['HTTP_REFERER']);
                                                                    }
                                                                }
                                                                if (isset($_GET['submit'])) {
                                                                    $url = new URL("https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                                                                    $url->remove_param('submit');
                                                                    $url->redirect();
                                                                }
                                                                
                                                                if($page > 1){
                                                                    $uri_p = (isset($_GET['filter'])) ? $url->url.'&page='.$page_minus : $_SERVER['PHP_SELF'].'?page='.$page_minus;
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
                                                            href="<?php echo (isset($_GET['filter'])) ? $url->url.'&page='.$page_plus : $_SERVER['PHP_SELF'].'?page='.$page_plus;?>">Next <span aria-hidden="true">&raquo;</span></a>
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