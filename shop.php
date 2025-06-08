<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rental Orb - Shopping Mall</title>
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
                        <section class="py-5 mb-5 col-lg-12" style="background: url(files/background-pattern.jpg);">
                            <div class="container-fluid">
                                <div class="d-flex justify-content-between">
                                <h1 class="page-title pb-2 text-danger">Shop System Is Not Functional</h1>
                                    <nav class="breadcrumb fs-6">
                                        <a class="breadcrumb-item " href="#">Home</a>
                                        <a class="breadcrumb-item " href="#">Pages</a>
                                        <span class="breadcrumb-item active" aria-current="page">Shop</span>
                                    </nav>
                                </div>
                            </div>
                        </section>
                        <!-- <div class="my-3 px-4">
                            <h4 class="fw-bold h-font text-center text-danger">SHOPING SYSTM IS UNDER MAINTENANCE</h4>
                            <div class="h-line bg-danger"></div>
                        </div> -->
                        <div class="col-lg-12">
                            <div class="row">
                                <!-- Filter Nav -->
                                <div class="col-lg-3 col-md-12 mb-lg-0 mb-4">
                                    <nav class="nav navbar-expand-lg bg-white rounded shadow">
                                        <div class="container-fluid flex-lg-column align-items-stretch">
                                            <h4 class="mt-2">FILTERS</h4>
                                            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                                <span class="navbar-toggler-icon"></span>
                                            </button>
                                            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                                                <div class="sidebar">
                                                    <div class="widget-menu">
                                                        <div class="widget-search-bar">
                                                        <form role="search" method="get" class="d-flex">
                                                            
                                                            <input class="form-control form-control-lg rounded-start rounded-0 bg-light" type="email" placeholder="What are you looking for?" aria-label="What are you looking for?">
                                                            <button class="btn btn-outline-secondary rounded-end rounded-0" type="submit">Search</button>
                                                            </form>
                                                        
                                                        </div> 
                                                    </div>
                                                    <div class="widget-product-categories pt-5">
                                                        <h5 class="widget-title">Categories</h5>
                                                        <ul class="product-categories sidebar-list list-unstyled">
                                                        <li class="cat-item">
                                                            <a href="#" class="">All Items</a>
                                                        </li>
                                                        <li class="cat-item">
                                                            <a href="#" class="">Phones</a>
                                                        </li>
                                                        <li class="cat-item">
                                                            <a href="#" class="">Accessories</a>
                                                        </li>
                                                        <li class="cat-item">
                                                            <a href="#" class="">Tablets</a>
                                                        </li>
                                                        <li class="cat-item">
                                                            <a href="#" class="">Watches</a>
                                                        </li>
                                                        </ul>
                                                    </div>
                                                    <div class="widget-product-tags pt-3">
                                                        <h5 class="widget-title">Tags</h5>
                                                        <ul class="product-tags sidebar-list list-unstyled">
                                                        <li class="tags-item">
                                                            <a href="#" class="">White</a>
                                                        </li>
                                                        <li class="tags-item">
                                                            <a href="#" class="">Cheap</a>
                                                        </li>
                                                        <li class="tags-item">
                                                            <a href="#" class="">Mobile</a>
                                                        </li>
                                                        <li class="tags-item">
                                                            <a href="#" class="">Modern</a>
                                                        </li>
                                                        </ul>
                                                    </div>
                                                    <div class="widget-product-brands pt-3">
                                                        <h5 class="widget-title">Brands</h5>
                                                        <ul class="product-tags sidebar-list list-unstyled">
                                                        <li class="tags-item">
                                                            <a href="#" class="">Apple</a>
                                                        </li>
                                                        <li class="tags-item">
                                                            <a href="#" class="">Samsung</a>
                                                        </li>
                                                        <li class="tags-item">
                                                            <a href="#" class="">Huwai</a>
                                                        </li>
                                                        </ul>
                                                    </div>
                                                    <div class="widget-price-filter pt-3">
                                                        <h5 class="widget-titlewidget-title">Filter By Price</h5>
                                                        <ul class="product-tags sidebar-list list-unstyled">
                                                        <li class="tags-item">
                                                            <a href="#" class="">Less than $10</a>
                                                        </li>
                                                        <li class="tags-item">
                                                            <a href="#" class="">$10- $20</a>
                                                        </li>
                                                        <li class="tags-item">
                                                            <a href="#" class="">$20- $30</a>
                                                        </li>
                                                        <li class="tags-item">
                                                            <a href="#" class="">$30- $40</a>
                                                        </li>
                                                        <li class="tags-item">
                                                            <a href="#" class="">$40- $50</a>
                                                        </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </nav>
                                </div>

                                <!-- Main Content -->
                                <div class="col-lg-9 col-md-12">
                                    <div class="filter-shop d-flex justify-content-between">
                                        <div class="showing-product mt-2">
                                            <?php
                                            $num_per_page = 10;
                                            $page = (isset($_GET['page']) ? $_GET['page'] : 1);
                                            $start_from = ($page - 1) * 5;
                                            
                                            // nummber of results query
                                            $sql_q_results = "SELECT * FROM `shop`
                                            ORDER BY `shop`.`date`
                                            DESC LIMIT $start_from, $num_per_page";
                                            
                                            $conn_res = mysqli_query($con, $sql_q_results);
                                            $num_res = mysqli_num_rows($conn_res);
                                            ?>
                                            <p>Showing <?=$num_res;?> results</p>
                                        </div>
                                        <div class="sort-by">
                                            <select id="input-sort" class="form-control" data-filter-sort="" data-filter-order="">
                                            <option value="">Default sorting</option>
                                            <option value="">Name (A - Z)</option>
                                            <option value="">Name (Z - A)</option>
                                            <option value="">Price (Low-High)</option>
                                            <option value="">Price (High-Low)</option>
                                            <option value="">Rating (Highest)</option>
                                            <option value="">Rating (Lowest)</option>
                                            <option value="">Model (A - Z)</option>
                                            <option value="">Model (Z - A)</option>   
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="product-grid row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                                    <?php
                                    
                                        $randomToken = randomString(50);

                                        // Fetch products for the current page
                                        $sql = "SELECT * FROM `shop`
                                        ORDER BY `shop`.`is_inStock` AND `shop`.`date`
                                        DESC LIMIT $start_from, $num_per_page";

                                        $result = $con->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                if ($row['photo1'] != null){
                                                    $photo = $row['photo1'];
                                                } else {
                                                    if ($row['photo2'] != null){
                                                        $photo = $row['photo2'];
                                                    } else {
                                                        if ($row['photo3'] != null){
                                                            $photo = $row['photo3'];
                                                        } else {
                                                            $photo = "thumbnail.png";
                                                        }
                                                    }
                                                }

                                                $isStock = ($row['is_inStock'] == 1) ? '<a href="#" class=" cart-hov">Add to Cart <i class="bi bi-bag-heart" style="font-size: x-large;"></i></a>' : '<a class=" cart-hov">Out of Stock <i class="bi bi-bag-x" style="font-size: x-large;"></i></a>';

                                                echo <<<shopProducts
                                                    <div class="col">
                                                        <div class="product-item">
                                                            <a href="#" class="btn-wishlist"><i class="bi bi-heart"></i></a>
                                                            <figure>
                                                                <a href="productDetails.php?pid={$row['id']}&refer=shop&token={$randomToken}" title="{$row['name']}">
                                                                    <img src="files/thumbnail/{$photo}" class="tab-image">
                                                                </a>
                                                            </figure>
                                                            <h3>{$row['name']}</h3>
                                                            <span class="qty">1 Unit</span>
                                                            <span class="rating">
                                                                <i class="bi bi-star-fill text-warning"></i> 4.5
                                                            </span>
                                                            <span class="price">৳{$row['price']}</span>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="input-group product-qty">
                                                                    <button type="button" id="decrement" class="decrement quantity-left-minus btn btn-danger btn-number bi bi-dash" data-type="minus" data-field="">
                                                                    </button>
                                                                    <input type="text" id="quantity" name="quantity" class="form-control input-number" value="10" min="1" max="100">
                                                                    <button type="button" id="increment" class="increment quantity-right-plus btn btn-success btn-number bi bi-plus" data-type="plus" data-field="">
                                                                    </button>
                                                                </div>
                                                                {$isStock}
                                                            </div>
                                                        </div>
                                                    </div>
                                                shopProducts;
                                            }
                                        }
                                    ?>
                                    
                                    </div>
                                    <!-- / product-grid -->

                                    <nav class="navigation paging-navigation text-center padding-medium" role="navigation">
                                        <div class="pagination loop-pagination d-flex justify-content-center align-items-center">
                                            <a href="#" style="color: #686868;font-size: 1.5rem;">
                                                <i class="bi bi-caret-left-fill"></i>
                                            </a>
                                            <span aria-current="page" class="page-numbers current pe-3" style="color: #e99743;font-size: 1.5rem;">1</span>
                                            <a class="page-numbers pe-3" href="#" style="color: #686868;font-size: 1.5rem;">2</a>
                                            <a class="page-numbers pe-3" href="#" style="color: #686868;font-size: 1.5rem;">3</a>
                                            <a class="page-numbers pe-3" href="#" style="color: #686868;font-size: 1.5rem;">4</a>
                                            <a class="page-numbers" href="#" style="color: #686868;font-size: 1.5rem;">5</a>
                                            <a href="#" style="color: #686868;font-size: 1.5rem;">
                                                <i class="bi bi-caret-right-fill"></i>
                                            </a>
                                        </div>
                                    </nav>

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