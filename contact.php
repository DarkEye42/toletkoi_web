<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - ToletKoi</title>
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
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="my-5 px-4">
                                    <h2 class="fw-bold h-font text-center">CONTACT US</h2>
                                    <div class="h-line bg-dark"></div>
                                    <p class="text-center mt-3">
                                        Finding a home in Bangladesh made easy with ToletKoi. Browse, rent, and enjoy exceptional customer support.<br/> your search with us! #ToletKoi
                                    </p>
                                </div>
                                <!-- Map View -->
                                <div class="col-lg-6 col-md-6 mb-5 px-4">
                                    <div class="bg-white rounded shadow p-4">
                                        <iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $contact_result['iframe']; ?>"></iframe>
                                        <!-- <iframe class="w-100 rounded mb-4" height="320px" src="https://www.google.com/maps/embed?pb=!2d90.3820205!3d24.015462"></iframe> -->
                                        <h5>Address</h5>
                                        <a href="<?php echo $contact_result['gmap']; ?>" target="_blank" class="d-line-block text-decoration-none mb-2">
                                            <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_result['address']; ?>
                                        </a>
                                        <h6 class="mt-4">Call Us</h6>
                                        <a href="tel: <?php echo "+",$contact_result['phn1']; ?>" class="d-line-block text-decoration-none">
                                            <i class="bi bi-telephone-fill"></i> <?php echo "+",$contact_result['phn1']; ?>
                                        </a>
                                        <?php if($contact_result['phn2'] != ""){ ?>
                                        <br>
                                        <a href="tel: <?php echo "+",$contact_result['phn2']; ?>" class="d-line-block text-decoration-none">
                                            <i class="bi bi-telephone-fill"></i> <?php echo "+",$contact_result['phn2']; ?>
                                        </a>
                                        <?php } ?>
                    
                                        <h6 class="mt-4">Email Us</h6>
                                        <a href="mailto: <?php echo $contact_result['email']; ?>" class="d-line-block text-decoration-none">
                                            <i class="bi bi-envelope-at-fill"></i> <?php echo $contact_result['email']; ?>
                                        </a>
                    
                                        <h6 class="mt-4">Follow Us</h6>
                                        <a href="<?php echo $contact_result['tw']; ?>" class="d-inline-block mb-2 me-2 fs-5">
                                            <i class="bi bi-twitter me-1"></i>
                                        </a>
                                        <a href="<?php echo $contact_result['fb']; ?>" class="d-inline-block mb-2 me-2 fs-5">
                                            <i class="bi bi-facebook me-1"></i>
                                        </a>
                                        <a href="<?php echo $contact_result['yt']; ?>" class="d-inline-block mb-2 fs-5">
                                            <i class="bi bi-youtube me-1"></i>
                                        </a>
                                    </div>
                                </div>

                                <?php
                                    // Check if the form is submitted
                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    
                                        // Get the form fields
                                        $name = $_POST["name"];
                                        $subject = $_POST["subject"];
                                        $email = $_POST["email"];
                                        $message = $_POST["message_var"];
                                        
                                        // Validate the form fields (you can add more validation if required)
                                        if (empty($name) || empty($email) || empty($message) || empty($subject)) {
                                            $errorMessage = "Please fill in all the fields.";
                                        }
                                        
                                        // Set the recipient email address
                                        $to = "contact@ToletKoi.com"; // Replace with your own email address
                                        
                                        // Build the email body
                                        $body = "Name: $name\n";
                                        $body .= "Email: $email\n";
                                        $body .= "Message: $message\n";

                                        // Set additional headers
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
                                        $headers .= "From: $email\r\n";
                                        $headers .= "Reply-To: $email\r\n";
                                        
                                        // Attempt to send the email
                                        if (mail($to, $subject, $body, $headers)) {
                                            $successMessage = "Thank you for contacting us. We will get back to you soon.";
                                        } else {
                                            $errorMessage = "Oops! Something went wrong. Please try again later.";
                                        }
                                    }
                                    ?>


                                <!-- Contact Form -->
                                <div class="col-lg-6 col-md-6 px-4">
                                    <div class="bg-white rounded shadow p-4">
                                    <?php if (isset($successMessage)){
                                        alert("success",$successMessage);
                                    } else if (isset($errorMessage)){
                                        alert("error",$errorMessage);
                                    } ?>
                                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <h5>Send a Message</h5>
                                            <div class="mt-3">
                                                <label class="form-label fw-bold">Name</label>
                                                <input type="text" name="name" class="form-control shadow-none" required/>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label fw-bold">Email</label>
                                                <input type="email" name="email" class="form-control shadow-none" required/>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label fw-bold">Subject</label>
                                                <input type="text" name="subject" class="form-control shadow-none" required/>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label fw-bold">Message</label>
                                                <textarea class="form-control shadow-none" name="message_var" rows="5" style="resize: none;" required></textarea>
                                            </div>
                                            <button type="submit" class="btn text-white custom-bg mt-3">SEND</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
