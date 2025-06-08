<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Privacy & Policy - RentalOrb</title>
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
                        <div class="my-5 px-4">
                            <h2 class="fw-bold h-font text-center">PRIVACY & POLICY</h2>
                            <div class="h-line bg-dark"></div>
                        </div>
                        <div class="col-lg-8 m-auto align-self-center">
                            <section>
                                <h2>Introduction</h2>
                                <p>Welcome to RentalOrb, a house and service rental service in Bangladesh. This Privacy & Policy page aims to inform you about the collection, usage, and disclosure of personal information when you use our website and mobile app.</p>
                            </section>

                            <section>
                                <h2>Collection of Personal Information</h2>
                                <p>In order to provide you with our services and ensure a secure and reliable user experience, RentalOrb may collect and process the following personal information:</p>
                                <ul>
                                    <li>Full name</li>
                                    <li>Contact information (email address, phone number, etc.)</li>
                                    <li>Live geolocation data</li>
                                    <li>Any other information you choose to provide</li>
                                </ul>
                                <p>We collect this information to authenticate and validate users, facilitate bookings, improve our services, and comply with legal obligations.</p>
                            </section>

                            <section>
                                <h2>Usage of Personal Information</h2>
                                <p>RentalOrb uses the collected personal information for various purposes, including:</p>
                                <ul>
                                    <li>Facilitating the rental booking process</li>
                                    <li>Improving and personalizing our services</li>
                                    <li>Communicating with users regarding their bookings and inquiries</li>
                                    <li>Analyzing usage patterns and trends</li>
                                    <li>Enhancing the security and safety of our platform</li>
                                </ul>
                            </section>

                            <section>
                                <h2>Disclosure of Personal Information</h2>
                                <p>RentalOrb may share your personal information with third parties in the following circumstances:</p>
                                <ul>
                                    <li>With the consent of the user</li>
                                    <li>To comply with legal obligations or respond to lawful requests</li>
                                    <li>To protect the rights, property, or safety of RentalOrb, its users, or the public</li>
                                    <li>With service providers who assist in the operations of our platform</li>
                                    <li>In the event of a merger, acquisition, or sale of all or a portion of RentalOrb's assets</li>
                                </ul>
                            </section>

                            <section>
                                <h2>Data Security</h2>
                                <p>RentalOrb takes reasonable measures to protect the personal information we collect. However, please be aware that no method of transmission or storage is 100% secure, and we cannot guarantee absolute security.</p>
                            </section>

                            <section>
                                <h2>Governmental Cooperation</h2>
                                <p>In compliance with applicable laws and regulations, RentalOrb may be required to disclose personal information to governmental or law enforcement authorities for purposes such as identifying crime-related individuals or assisting in investigations. We strive to ensure that such disclosures are in accordance with the law.</p>
                            </section>

                            <section>
                                <h2>Changes to this Privacy & Policy</h2>
                                <p>RentalOrb reserves the right to update or modify this Privacy & Policy at any time. We encourage users to review this page periodically for any changes. Continued use of our services after any modifications signify your acceptance of the revised Privacy & Policy.</p>
                            </section>

                            <section>
                                <h2>Contact Us</h2>
                                <p>If you have any questions or concerns about this Privacy & Policy, please contact us at:</p>
                                    <address>
                                        RentalOrb<br>
                                        123 Main Street<br>
                                        Dhaka, Bangladesh<br>
                                        Email: info@rentalorb.com<br>
                                        Phone: +880 123456789
                                    </address>
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