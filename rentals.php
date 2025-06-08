<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Search & Explore Rentals - ToletKoi</title>
    <?php
        class URL{
            public $url = '';

            function __construct($url)
            {
                $this->url = $url;
            }

            function redirect($response_code = 301)
            {
                echo "<script> window.location.href='$this->url'; </script>";
                //header("Location:".$this->url, true, $response_code);
                exit;
            }

            function remove_param($param)
            {
                // Do nothing to URL without a Query String (hat tip @eggyal)
                if (strpos($this->url, '?') === false) return $this->url;

                // Split URL into base URL and Query String
                list($url, $query) = explode('?', $this->url, 2);

                // Parse Query String into array
                parse_str($query, $params);

                // Remove the parameter in question
                unset($params[$param]);

                // Rebuild Query String
                $query = http_build_query($params);

                // Piece URL back together and save to object
                $this->url = $url . ($query ? "?$query" : '');

                // Return URL in case developer really just wants an instant result
                return $this->url;
            }
        }

        $category = isset($_GET['category']) ? str_replace("-", " ", $_GET['category']) : null;
        $area = isset($_GET['area']) ? str_replace("-", " ", $_GET['area']) : null;

        require('include/commonLinks.php');
    ?>
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
                        <div class="my-3 px-4">
                            <h4 class="fw-bold h-font text-center">EXPLORE RENTALS</h4>
                            <div class="h-line bg-secondary"></div>
                        </div>



                        <div class="col-lg-9 col-md-12">
                            <!-- Explore Ads Section Start -->
                                <div class="row g-2 mt-0 mx-2 mb-n30px">

                                    <?php
                                    if (isset($_GET['area']) && !isset($_GET['category'])) {
                                        $area = str_replace("-", " ", $_GET['area']);
                                        $allAds = getAreaPosts($area);
                                    } elseif (!isset($_GET['area']) && isset($_GET['category'])) {
                                        $category = str_replace("-", " ", $_GET['category']);
                                        $allAds = getCategoryPosts($category);
                                    } else if(isset($_GET['area']) && isset($_GET['category'])){
                                        $area = str_replace("-", " ", $_GET['area']);
                                        $category = str_replace("-", " ", $_GET['category']);
                                        $allAds = getSimilarPosts($area, $category);
                                    }
                                    
                                    if ($allAds) {
                                        foreach ($allAds as $row) {
                                            echo '<div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2">
                                                        <div class="card shadow">
                                                            <div id="carousel' . $row['uniqueId'] . '" class="carousel slide carousel-fade">
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
                                    ?>

                                </div>
                            <!-- Explore Ads Section End -->
                            <?php
                            } else {
                            ?>
                                <div class="card w-100 shadow border border-0">
                                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                    <lottie-player class="card-img-top" src="https://assets3.lottiefiles.com/private_files/lf30_3X1oGR.json" background="transparent" speed="1" style="padding: 5px; height: 350px;" loop autoplay></lottie-player>
                                    <div class="card-body">
                                        <h2 class="card-text fw-bold text-center">Here are no matched rental ads with your filtered data.</h2>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="col-lg-3 col-md-12 mb-lg-0 mb-4">
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php include('include/footer2.php'); ?>
        </div>
        <!-- Main Section End -->
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>