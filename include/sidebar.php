<?php session_start(); ?>
<!-- Sidebar Section Start -->
<div class="col-lg-2 me-2 inherit-margin-left">
    <div class="col-lg-2 ms-0 bg-white shadow" id="header-menu">
        <nav class="navbar navbar-expand-lg navbar-white">
            <div class="container-fluid flex-lg-column align-items-stretch">
            <span class="w-lg-100 text-center">
                <img class="my-2 my-lg-1 mb-lg-3" src="admin/images/logo.png" alt="logo" width="120px" height="50px"/>
            </span>
            <button class="navbar-toggler shadow-none my-2 my-lg-1" type="button" data-bs-toggle="collapse" data-bs-target="#navDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-3" id="navDropdown">
                <ul class="nav nav-pills flex-column custom-z-index" id="side-bar">
                    <li class="nav-item">
                        <a class="nav-link text-dark fs-6 nav-hover" href="index.php"><i class="bi bi-house fw-bold fs-5 me-3"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fs-6 nav-hover" href="rentals.php"><i class="bi bi-compass fw-bold fs-5 me-3"></i> Explore Rentals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fs-6 nav-hover" href="shop.php"><i class="bi bi-shop fw-bold fs-5 me-3"></i> Shoping</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fs-6 nav-hover" href="cart.php"><i class="bi bi-cart3 fw-bold fs-5 me-3"></i> Cart</a>
                    </li>
                    <?php
                        if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true){
                            $createPostId = "#createAdsModel";
                    ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-6 nav-hover" href="createads.php"><i class="bi bi-file-earmark-plus fw-bold fs-5 me-3"></i> Create Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-6 nav-hover" href="saved_ads.php"><i class="bi bi-heart fw-bold fs-5 me-3"></i> Saved</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-6 nav-hover" href="profile.php"><i class="bi bi-people fw-bold fs-5 me-3"></i> Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-6 nav-hover" href="settings.php"><i class="bi bi-sliders fw-bold fs-5 me-3"></i> Settings</a>
                        </li>
                    <?php
                        } else {
                            $createPostId = "#loginModel";
                    ?>
                    <h6 class="nav-link text-muted mb-0 mobile-tablet-button">Auth Links</h6>
                            <li class="nav-item mobile-tablet-button">
                                <a class="nav-link text-dark fs-6 nav-hover" href="#" type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModel"><i class="bi bi-person-fill-lock fw-bold fs-5 me-3"></i> Login</a>
                            </li>
                            <li class="nav-item mobile-tablet-button">
                                <a class="nav-link text-dark fs-6 nav-hover" href="#" type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModel"><i class="bi bi-person-vcard fw-bold fs-5 me-3"></i> Register</a>
                            </li>
                    <?php
                        }
                    ?>
                    <h6 class="nav-link text-muted mb-0">Quick Links</h6>

                    <li class="nav-item">
                        <a class="nav-link text-dark fs-6 nav-hover" href="contact.php"><i class="bi bi-chat-left-text fw-bold fs-5 me-3"></i> Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fs-6 nav-hover" href="about.php"><i class="bi bi-exclamation-circle fw-bold fs-5 me-3"></i> About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fs-6 nav-hover" href="privacy.php"><i class="bi bi-shield-check fw-bold fs-5 me-3"></i> Privacy & Policy</a>
                    </li>
                </ul>
            </div>
            
            <div class="card border-0 mt-4 custom-rounded shadow gradient text-center auto-hide">
                <div class="card-body">
                    <h1 class="card-title"><i class="bi bi-plus-circle"></i></h1>
                    <h5 class="card-subtitle mb-2 text-light">Create A Rental Post</h5>
                    <p class="card-text" style="font-size: small;">Create a rental post and get your renter quickly. The expected renter will contact you if your requirements meet with them.</p>
                    <button type="button" class="btn custom-bg text-light shadow-sm border-0" data-bs-toggle="modal" data-bs-target="<?php echo $createPostId; ?>">Create a Post</button>
                </div>
            </div>
        </div>
        </nav>
    </div>
</div>
<!-- Sidebar Section End -->