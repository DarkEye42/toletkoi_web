<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us - ToletKoi</title>
    <?php include('include/commonLinks.php') ?>
    <link rel="stylesheet" href="include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div id="app" style="overflow: hidden;">
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
                        <div class="container-fluid ms-auto">
                            <div class="my-5 px-4">
                                <h2 class="fw-bold h-font text-center">ABOUT US</h2>
                                <div class="h-line bg-dark"></div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                        <p class="lead justify-content-center align-items-center mt-3 fw-bold">Your Trusted House & Service Rental Platform in Bangladesh</p>
                                        <p>ToletKoi is a leading rental service provider in Bangladesh, offering a convenient and secure platform for users to rent houses and services across the country. With our user-friendly website and dedicated mobile app, finding your dream home or accessing reliable services has never been easier.</p>
                                        <p>We understand the importance of trust and safety when it comes to renting properties or availing services, which is why we have implemented advanced security measures to ensure the protection of our users' information and maintain a secure online environment.</p>
                                        <h2 class="justify-content-center align-items-center">Our Commitment to Privacy and Data Security</h2>
                                        <p>At ToletKoi, we prioritize the privacy and security of our users' personal information. We collect data such as live geolocation and users' personal details to validate their accounts and ensure the accuracy of rental listings and service requests.</p>
                                        <p>Rest assured that we handle all user data with utmost care and follow strict privacy protocols. We are committed to complying with all applicable data protection laws and regulations.</p>
                                        <p>Please note that ToletKoi may share collected data with governmental services, such as the Bangladesh Police, in cases where it is necessary for identifying crime-related individuals or maintaining public safety. Such data sharing is done in accordance with legal requirements and procedures.</p>
                                        <h2 class="justify-content-center align-items-center">Features and Benefits</h2>
                                        <p><strong>1. Extensive Rental Listings:</strong> Explore a wide range of houses and properties available for rent in various cities and towns across Bangladesh. Our comprehensive database ensures you find the perfect home that suits your needs.</p>
                                        <p><strong>2. Reliable Service Providers:</strong> Connect with trusted service providers for all your needs, whether it's maintenance, cleaning, or any other service required for your rented property. We verify and vet all service providers to ensure their reliability.</p>
                                        <p><strong>3. User-Friendly Platform:</strong> Our website and mobile app are designed with simplicity and ease of use in mind. You can easily navigate through listings, filter your search results, and communicate with property owners or service providers.</p>
                                        <p><strong>4. Secure Transactions:</strong> Rent or hire services with confidence through our secure payment gateway. We prioritize the safety of your financial transactions and employ advanced encryption technology to safeguard your sensitive information.</p>
                                        <p><strong>5. 24/7 Customer Support:</strong> Our dedicated customer support team is available round the clock to assist you with any queries or concerns you may have. We strive to provide timely and effective support to ensure a smooth rental experience.</p>
                                        <h2 class="justify-content-center align-items-center">Join ToletKoi Today</h2>
                                        <p>Whether you're searching for a new home or need reliable services for your rented property, ToletKoi is your go-to platform in Bangladesh. Join our growing community of satisfied users and experience the convenience and peace of mind that comes with our trusted rental services.</p>
                                        <p>Download our mobile app or visit our website to get started today!</p>
                                        <button class="btn btn-primary">Download App</button>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                                    <h3 class="mb-3">Chief Executive Officer</h3>
                                    <p>
                                        <b style="font-size: 1.2rem !important;">Name: Md. Nazmul Islam</b><br/>About: He is chief executive officer & chairman of Rental Orb. He is also the founder & developer of our web and mobile apps. Thank you.
                                    </p>
                                </div>
                                <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                                    <img src="files/admin/about/dev_img.jpg" alt="" class="w-100 rounded" style="max-height: 350px; max-width:fit-content"/>
                                </div>
                            </div>
                        </div>       
                        <div class="col-lg-3 col-md-6 mb-4 px-4">
                            <div class="bg-white rounded shadow p-4 border-4 text-center box">
                                <img src="files/admin/about/hotel.svg" alt="" width="70px"/>
                                <h4 class="mt-3">1.3M+ RENTAL ADS</h4>
                            </div>
                        </div>       
                        <div class="col-lg-3 col-md-6 mb-4 px-4">
                            <div class="bg-white rounded shadow p-4 border-4 text-center box">
                                <img src="files/admin/about/customers.svg" alt="" width="70px"/>
                                <h4 class="mt-3">236K+ USERS</h4>
                            </div>
                        </div>       
                        <div class="col-lg-3 col-md-6 mb-4 px-4">
                            <div class="bg-white rounded shadow p-4 border-4 text-center box">
                                <img src="files/admin/about/rating.svg" alt="" width="70px"/>
                                <h4 class="mt-3">180K+ REVIEWS</h4>
                            </div>
                        </div>      
                        <div class="col-lg-3 col-md-6 mb-4 px-4">
                            <div class="bg-white rounded shadow p-4 border-4 text-center box">
                                <img src="files/admin/about/staff.svg" alt="" width="70px"/>
                                <h4 class="mt-3">24/7 LIVE SUPPORT</h4>
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