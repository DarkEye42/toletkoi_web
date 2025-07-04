<!DOCTYPE html>
<html lang="en">
<?php
    require("admin/include/db_config.php");
    require("admin/include/essentials.php");
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        <?php
            // Get the ID from the query string
            $id = isset($_GET['pid']) ? $_GET['pid'] : null;
            // Fetch data from the database
            $sql = "SELECT * FROM shop WHERE id = '$id'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row['title'] . '  - Rental Orb';
            }
        ?>
    </title>
    <?php include('include/commonLinks.php') ?>
    <link rel="stylesheet" href="include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        .icon-hover:hover {
            border-color: #3b71ca !important;
            background-color: white !important;
            color: #3b71ca !important;
        }

        .icon-hover:hover i {
            color: #3b71ca !important;
        }

        .custom-nav-link {
            border-radius: 0;
            text-transform: uppercase;
            line-height: 1;
            --bs-nav-link-color: var(--bs-gray-700);
            --bs-nav-link-hover-color: var(--bs-black);
        }

        .custom-nav-link:hover {
            background: var(--bs-gray-100) !important;
            font-weight: 500 !important;
        }

        .active:hover {
            background: none !important;
            font-weight: unset !important;
        }
    </style>
</head>

<body>
    <div id="app">
    <?php
        include('include/sidebar2.php');
    ?>
    <!-- Main Section Start -->
        <div id="main" class="layout-navbar">
            <header class="mb-3 sticky-top bg-white">
                <?php include('include/navbar.php') ?>
            </header>
            <div id="main-content">
                <div class="container-fluid">
            
                    <?php if (isset($_GET["token"])) { ?>
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="my-5 px-4">
                                            <h2 class="fw-bold h-font text-center">PRODUCTS DETAILS</h2>
                                            <div class="h-line bg-dark"></div>
                                            <p class="text-center mt-3">
                                                This features will be live soon. Please stay tuned.
                                            </p>
                                        </div>
                                        <span class="align-middle" style="height: 356px;">
                                            <h1 class="text-center">COMING SOON...!</h1>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>

                        <div class="row">
                            <?php
                                // Get the ID from the query string
                                $id = isset($_GET['pid']) ? $_GET['pid'] : null;

                                //$id = 7;

                                // Fetch data from the database
                                $sql = "SELECT * FROM shop WHERE id = '$id'";
                                $result = $con->query($sql);
                            ?>
                            <div class="col-lg-10">
                                <!-- content -->
                                <?php
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $isStock = ($row['is_inStock'] == 1) ? '<span class="text-success ms-2">In stock</span>' : '<span class="text-danger ms-2">Out of stock</span>';
                                ?>
                                <section class="mb-5">
                                    <div class="container">
                                        <div class="row gx-5">
                                            <aside class="col-lg-6">
                                                <div class="border rounded-4 mb-3 d-flex justify-content-center">
                                                    <div id="previewContainer">
                                                        <div id="zoomContainer">
                                                            <img id="previewImage" style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit preview-image" src="files/thumbnail/<?= $row['photo1'];?>" />
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div id="thumbnailContainer" class="d-flex justify-content-center mb-3">
                                                    <a data-fslightbox="mygalley" class="border mx-1 rounded-2" data-type="image" class="item-thumb">
                                                        <img width="60" height="60" class="rounded-2 thumbnail" src="files/thumbnail/<?= $row['photo1'];?>" />
                                                    </a>
                                                    <a data-fslightbox="mygalley" class="border mx-1 rounded-2" data-type="image" class="item-thumb">
                                                        <img width="60" height="60" class="rounded-2 thumbnail" src="files/thumbnail/<?= $row['photo2'];?>" />
                                                    </a>
                                                    <a data-fslightbox="mygalley" class="border mx-1 rounded-2" data-type="image" class="item-thumb">
                                                        <img width="60" height="60" class="rounded-2 thumbnail" src="files/thumbnail/<?= $row['photo3'];?>" />
                                                    </a>
                                                </div>
                                                <!-- thumbs-wrap.// -->
                                                <!-- gallery-wrap .end// -->
                                            </aside>
                                            <main class="col-lg-6">
                                                <div class="ps-lg-3">
                                                    <h4 class="title">
                                                        <?= $row['name'];?>
                                                    </h4>
                                                    <div class="d-flex flex-row my-3">
                                                        <div class="text-warning mb-1 me-2">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fas fa-star-half-alt"></i>
                                                            <span class="ms-1">
                                                                4.5
                                                            </span>
                                                        </div>
                                                        <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>235 orders</span>
                                                        <?= $isStock; ?>
                                                    </div>

                                                    <div class="mb-3">
                                                        <span class="h5">৳<?= $row['price'];?></span>
                                                        <span class="text-muted">/per unit</span>
                                                    </div>

                                                    <p>
                                                        Modern look and quality demo item is a streetwear-inspired collection that continues to break away from the conventions of mainstream fashion. Made in Italy, these black and brown clothing low-top shirts for
                                                        men.
                                                    </p>

                                                    <div class="row">
                                                        <dt class="col-3">Type:</dt>
                                                        <dd class="col-9">Regular</dd>

                                                        <dt class="col-3">Color</dt>
                                                        <dd class="col-9">Brown</dd>

                                                        <dt class="col-3">Material</dt>
                                                        <dd class="col-9">Cotton, Jeans</dd>

                                                        <dt class="col-3">Brand</dt>
                                                        <dd class="col-9">Reebook</dd>
                                                    </div>

                                                    <hr />

                                                    <div class="row mb-4">
                                                        <div class="col-md-4 col-6">
                                                            <label class="mb-2">Size</label>
                                                            <select class="form-select border border-secondary" style="height: 35px;">
                                                                <option>Small</option>
                                                                <option>Medium</option>
                                                                <option>Large</option>
                                                            </select>
                                                        </div>
                                                        <!-- col.// -->
                                                        <div class="col-md-4 col-6 mb-3">
                                                            <label class="mb-2 d-block">Quantity</label>
                                                            <div class="input-group mb-3" style="width: 170px;">
                                                                <button class="btn btn-white border border-secondary px-3" type="button" id="button-addon1" data-mdb-ripple-color="dark">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="text" class="form-control text-center border border-secondary" placeholder="14" aria-label="Example text with button addon" aria-describedby="button-addon1" />
                                                                <button class="btn btn-white border border-secondary px-3" type="button" id="button-addon2" data-mdb-ripple-color="dark">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-warning shadow-0 py-2 px-3"> Buy now </a>
                                                    <a href="#" class="btn btn-primary shadow-0 py-2 px-3"> <i class="me-1 fa fa-shopping-basket"></i> Add to cart </a>
                                                    <a href="#" class="btn btn-light border border-secondary py-2 icon-hover px-3"> <i class="me-1 fa fa-heart fa-lg"></i> Save </a>
                                                </div>
                                            </main>
                                        </div>
                                    </div>
                                </section>
                                <?php } ?>
                                <!-- content -->

                                <section class="border-top py-4">
                                    <div class="container">
                                        <div class="row gx-4">
                                            <div class="col-lg-8 mb-4">
                                                <div class="border rounded-2 px-3 py-2 bg-white">
                                                    <!-- Pills navs -->
                                                    <nav>
                                                        <div class="nav nav-tabs nav-justified mb-3" id="nav-tab" role="tablist">
                                                            <button class="nav-link p-3 custom-nav-link d-flex align-items-center justify-content-center w-100 active" id="nav-1-tab" data-bs-toggle="tab" data-bs-target="#nav-1" type="button" role="tab" aria-controls="nav-1" aria-selected="true">Specification</button>
                                                            <button class="nav-link p-3 custom-nav-link d-flex align-items-center justify-content-center w-100" id="nav-2-tab" data-bs-toggle="tab" data-bs-target="#nav-2" type="button" role="tab" aria-controls="nav-2" aria-selected="false">Warranty info</button>
                                                            <button class="nav-link p-3 custom-nav-link d-flex align-items-center justify-content-center w-100" id="nav-3-tab" data-bs-toggle="tab" data-bs-target="#nav-3" type="button" role="tab" aria-controls="nav-3" aria-selected="false">Shipping info</button>
                                                            <button class="nav-link p-3 custom-nav-link d-flex align-items-center justify-content-center w-100" id="nav-4-tab" data-bs-toggle="tab" data-bs-target="#nav-4" type="button" role="tab" aria-controls="nav-4" aria-selected="false">Seller profile</button>
                                                        </div>
                                                    </nav>
                                                    <!-- Pills navs -->

                                                    <!-- Pills content -->
                                                    <div class="tab-content" id="ads-tab-content">
                                                        <div class="tab-pane fade show active" id="nav-1" role="tabpanel" aria-labelledby="nav-1-tab">
                                                            <p>
                                                                With supporting text below as a natural lead-in to additional content. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                                                enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                                                pariatur.
                                                            </p>
                                                            <div class="row mb-2">
                                                                <div class="col-12 col-md-6">
                                                                    <ul class="list-unstyled mb-0">
                                                                        <li><i class="fas fa-check text-success me-2"></i>Some great feature name here</li>
                                                                        <li><i class="fas fa-check text-success me-2"></i>Lorem ipsum dolor sit amet, consectetur</li>
                                                                        <li><i class="fas fa-check text-success me-2"></i>Duis aute irure dolor in reprehenderit</li>
                                                                        <li><i class="fas fa-check text-success me-2"></i>Optical heart sensor</li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-12 col-md-6 mb-0">
                                                                    <ul class="list-unstyled">
                                                                        <li><i class="fas fa-check text-success me-2"></i>Easy fast and ver good</li>
                                                                        <li><i class="fas fa-check text-success me-2"></i>Some great feature name here</li>
                                                                        <li><i class="fas fa-check text-success me-2"></i>Modern style and design</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <table class="table border mt-3 mb-2">
                                                                <tr>
                                                                    <th class="py-2">Display:</th>
                                                                    <td class="py-2">13.3-inch LED-backlit display with IPS</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="py-2">Processor capacity:</th>
                                                                    <td class="py-2">2.3GHz dual-core Intel Core i5</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="py-2">Camera quality:</th>
                                                                    <td class="py-2">720p FaceTime HD camera</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="py-2">Memory</th>
                                                                    <td class="py-2">8 GB RAM or 16 GB RAM</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="py-2">Graphics</th>
                                                                    <td class="py-2">Intel Iris Plus Graphics 640</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="tab-pane fade mb-2" id="nav-2" role="tabpanel" aria-labelledby="nav-2-tab">
                                                            Tab content or sample information now <br />
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                            aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                                                            officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                        </div>
                                                        <div class="tab-pane fade mb-2" id="nav-3" role="tabpanel" aria-labelledby="nav-3-tab">
                                                            Another tab content or sample information now <br />
                                                            Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                                            commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                                            mollit anim id est laborum.
                                                        </div>
                                                        <div class="tab-pane fade mb-2" id="nav-4" role="tabpanel" aria-labelledby="nav-4-tab">
                                                            Some other tab content or sample information now <br />
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                            aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                                                            officia deserunt mollit anim id est laborum.
                                                        </div>
                                                    </div>
                                                    <!-- Pills content -->
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="px-0 border-1 rounded-2 shadow">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Similar items</h5>
                                                            <div class="d-flex mb-3">
                                                                <a href="#" class="me-3">
                                                                    <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/8.webp" style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                                                </a>
                                                                <div class="info">
                                                                    <a href="#" class="nav-link mb-1">
                                                                        Rucksack Backpack Large <br />
                                                                        Line Mounts
                                                                    </a>
                                                                    <strong class=""> $38.90</strong>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex mb-3">
                                                                <a href="#" class="me-3">
                                                                    <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/9.webp" style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                                                </a>
                                                                <div class="info">
                                                                    <a href="#" class="nav-link mb-1">
                                                                        Summer New Men's Denim <br />
                                                                        Jeans Shorts
                                                                    </a>
                                                                    <strong class=""> $29.50</strong>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex mb-3">
                                                                <a href="#" class="me-3">
                                                                    <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/10.webp" style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                                                </a>
                                                                <div class="info">
                                                                    <a href="#" class="nav-link mb-1"> T-shirts with multiple colors, for men and lady </a>
                                                                    <strong class=""> $120.00</strong>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex">
                                                                <a href="#" class="me-3">
                                                                    <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/11.webp" style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                                                </a>
                                                                <div class="info">
                                                                    <a href="#" class="nav-link mb-1"> Blazer Suit Dress Jacket for Men, Blue color </a>
                                                                    <strong class=""> $339.90</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    <?php } ?>
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