<nav class="navbar navbar-expand navbar-light navbar-top">
    <div class="container-fluid">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if(isset($_SESSION["userLogin"]) && $_SESSION["userLogin"] == true){ ?>
            <ul class="navbar-nav ms-auto mb-lg-0">
                <li class="nav-item dropdown me-1">
                    <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-envelope bi-sub fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">Mail</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">No new mail</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown me-3">
                    <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <i class="bi bi-bell bi-sub fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="dropdownMenuButton">
                        <li class="dropdown-header">
                            <h6>Notifications</h6>
                        </li>
                        <li class="dropdown-item notification-item">
                            <a class="d-flex align-items-center" href="#">
                                <div class="notification-icon bg-primary">
                                    <i class="bi bi-cart-check"></i>
                                </div>
                                <div class="notification-text ms-4">
                                    <p class="notification-title font-bold">
                                        Successfully check out
                                    </p>
                                    <p class="notification-subtitle font-thin text-sm">
                                        Order ID #256
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-item notification-item">
                            <a class="d-flex align-items-center" href="#">
                                <div class="notification-icon bg-success">
                                    <i class="bi bi-file-earmark-check"></i>
                                </div>
                                <div class="notification-text ms-4">
                                    <p class="notification-title font-bold">
                                        Homework submitted
                                    </p>
                                    <p class="notification-subtitle font-thin text-sm">
                                        Algebra math homework
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <p class="text-center py-2 mb-0">
                                <a href="#">See all notification</a>
                            </p>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600"><?=$user_result['first_name'].' '.$user_result['last_name']?></h6>
                            <p class="mb-0 text-sm text-gray-600"><?=$user_result['is_owner'] > 0 ? 'House Owner' : 'Renter';?></p>
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="files/<?=$user_result['avatar']?>" alt="<?=$user_result['first_name'].' '.$user_result['last_name']?>" />
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                    <li>
                        <h6 class="dropdown-header">Hello, <?=$user_result['first_name']?>!</h6>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i>
                            My Profile</a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                            Settings</a>
                    </li>

                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="logout"><i class="icon-mid bi bi-box-arrow-left me-2"></i>
                            Logout</a>
                    </li>
                </ul>
            </div>
            <?php } else { ?>
                <div class="col-12">
                    <div class="d-flex justify-content-end">
                        <!-- Button trigger modal -->
                        <a href="login.php" type="button" class="btn btn-outline-secondary shadow-none me-lg-3 me-2">
                        Login
                        </a>
                        <!-- <button type="button" class="btn btn-outline-secondary shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModel">
                        Login
                        </button> -->
                        <a href="signup.php" type="button" class="btn btn-outline-secondary shadow-none">
                        Register
                        </a>
                        <!-- <button type="button" class="btn btn-outline-secondary shadow-none" data-bs-toggle="modal" data-bs-target="#registerModel">
                        Register
                        </button> -->
                    </div>
                </div>
        <?php }
        if (isset($_POST["login"])){
            $from_data = filteration($_POST);
            $post_email = $from_data["email"];
            $post_phone = $from_data["phone"];
            $post_pass = md5($from_data["password"]);
            if(isset($_POST['phone']) && $_POST['phone'] != null){
                $res = mysqli_query($con, "SELECT * FROM `users` WHERE `phone`='$post_phone' AND `password`='$post_pass'");
            } else {
                $res = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$post_email' AND `password`='$post_pass'");
            }
            
            if (mysqli_num_rows($res)===1){
                $row = mysqli_fetch_assoc($res);
                $_SESSION["userLogin"] = true;
                $_SESSION["email"] = $row["email"];
                $_SESSION["id"] = $row["id"];
                $_SESSION["welcome"] = true;
                if ($row["is_owner"]==true) {
                    $_SESSION["is_owner"] = true;
                }
                redirect("index.php");
            } else {
                alert("error", "Login failed - Invalid Credentials!");
            }
        }

        if(isset($_GET["error"])){
            if ($_GET["error"]=="401"){
                alert("error", "401 - Unauthorized attempt to view this page.");
            }
        } else if(isset($_SESSION["welcome"])){
            if ($_SESSION["welcome"]==true){
                alert("success", "Welcome back!");
                unset($_SESSION["welcome"]);
                // echo '<script>setTimeout(function() {
                //     window.location.href = "index.php"; // Replace with your desired redirect URL
                //   }, 3000);</script>';
            }
        }
        ?>
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModel" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">   
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="login">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 align-items-center">
                    <i class="bi bi-person-circle fs-3 me-2"></i> Account Login
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <nav class="mb-3 w-100">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-email-tab" data-bs-toggle="tab" data-bs-target="#nav-email" type="button" role="tab" aria-controls="nav-email" aria-selected="true">Login Via Email</button>
                            <button class="nav-link" id="nav-phone-tab" data-bs-toggle="tab" data-bs-target="#nav-phone" type="button" role="tab" aria-controls="nav-phone" aria-selected="false">Phone Number</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-email" role="tabpanel" aria-labelledby="nav-email-tab" tabindex="0">
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control shadow-none">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-phone" role="tabpanel" aria-labelledby="nav-phone-tab" tabindex="0">
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="phone" name="phone" class="form-control shadow-none">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control shadow-none">
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <button type="submit" name="login" value="login" class="btn btn-primary shadow-none">Login</button>
                            <a href="forgot_password.php" class="text-danger fw-bold text-decoration-none"><i class="bi bi-person-fill-exclamation fs-5"></i> Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['register'])) {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $email = $_POST['email'];
    if (mb_strlen($_POST['phone']) > 11) {
        $phone = mb_substr($_POST['phone'], 0, 11);
    } else {
        $phone = $_POST['phone'];
    }
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $street = $_POST['street'];
    $village = $_POST['village'];
    $policeStation = $_POST['policeStation'];
    $district = $_POST['district'];
    $division = $_POST['division'];
    $zipCode = $_POST['zipCode'];
    $regMode = $_POST['inp_regMode'];
    $uniqueID = randomString(12);

    $md5_pass = md5($password);
    $village_var = $street. ', ' .$village;
    $joinDate = round(microtime(true) * 1000);
    $dob = strtotime($dateOfBirth) * 1000;

    if($password == $confirm_password){
        // Insert data into the "users" table
        $sql = "INSERT INTO users (unique_id, first_name, last_name, birthDate, email, phone, password, avatar, joinDate, village, policeStation, district, division, zipCode, isUpdated, is_owner)
        VALUES ('$uniqueID', '$firstName', '$lastName', '$dob', '$email', '$phone', '$md5_pass', 'user.jpg', '$joinDate', '$village_var', '$policeStation', '$district', '$division', '$zipCode', 0, '$regMode')";

        if ($con->query($sql) === true) {
            alert("success", "Registration successful!");
        } else {
            alert("error", "Error - Registration Failed!");
            //alert("error", "Error: " . $sql . "<br>" . $con->error);
        }
    } else {
        alert("error", "Error - Confirm Password not matching!");
    }
}
?>

<!-- Register Modal -->
<div class="modal fade" id="registerModel" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form class="needs-validation" action="" method="POST" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title fs-5 align-items-center">
                    <i class="bi bi-person-lines-fill fs-5 me-2"></i> Account Registration
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge bg-light-primary mb-3 text-wrap lh-base">
                    Note: Your given details must match with your ID (NID Card, Passport, or Driving License)
                    that will be required during renting.
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 ps-0 mb-3 ms-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="inp_regMode" id="reg-mode-select" value="0">
                                    <label class="form-check-label fs-5" for="reg-mode-select">
                                        Register As <code class="fw-bold" id="reg-mode">(Renter)</code>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">First Name</label>
                                <input name="firstName" type="text" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    First Name is require.
                                </div>
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Last Name</label>
                                <input name="lastName" type="text" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Last Name is require.
                                </div>
                            </div>
                            <div class="col-md-12 ps-0 mb-3">
                                <label class="form-label">Date of birth</label>
                                <input name="dateOfBirth" type="date" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Date of birth is require.
                                </div>
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control shadow-none" name="email" id="email" placeholder="name@example.com" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Email is not valid.
                                </div>
                                <span id="email-result"></span>
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input name="phone" type="phone" name="phone" class="form-control shadow-none"  placeholder="01XXX-XXXXXX" maxlength="11"  id="phone" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Phone number is not valid.
                                </div>
                                <span id="phone-result"></span>
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Password</label>
                                <input name="password" type="password" name="password" class="form-control shadow-none" id="password" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Password is require.
                                </div>
                                <span id="password-strength"></span>
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input name="confirm_password" type="password" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please confirm your password.
                                </div>
                            </div>
                            <div class="col-md-12 ps-0 mb-3">
                                <p class="fs-5">Address</p>
                            </div>
                            <div class="col-md-4 ps-0 mb-3">
                                <label class="form-label">Street/Road</label>
                                <input name="street" type="text|address" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Street/Road is require.
                                </div>
                            </div>
                            <div class="col-md-4 ps-0 mb-3">
                                <label class="form-label">Village/Area</label>
                                <input name="village" type="text|address" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Village/Area is require.
                                </div>
                            </div>
                            <div class="col-md-4 p-0 mb-3">
                                <label class="form-label">Police Station</label>
                                <input name="policeStation" type="text|address" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Police Station is require.
                                </div>
                            </div>
                            <div class="col-md-4 ps-0 mb-3">
                                <label class="form-label">District</label>
                                <input name="district" type="text|address" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Street/Road is require.
                                </div>
                            </div>
                            <div class="col-md-4 ps-0  mb-3">
                                <label class="form-label">Division</label>
                                <input name="division" type="text|address" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Village/Area is require.
                                </div>
                            </div>
                            <div class="col-md-4 p-0  mb-3">
                                <label class="form-label">Zip Code</label>
                                <input name="zipCode" type="text|address" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Police Station is require.
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                <label class="form-check-label" for="invalidCheck">
                                    Agree to terms and conditions
                                </label>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    You must agree before submitting.
                                </div>
                                </div>
                            </div>

                            <div class="col-12 mb-lg-3 mb-2 text-center">
                                <button class="btn btn-primary shadow-none" name="register" type="submit">Confirm Register</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ads Post Modal -->
<div class="modal fade" id="createAdsModel" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 align-items-center">
                <i class="bi bi-card-list fs-3 me-2"></i> Please input your property address
                </h5>
                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-hover">
                <form enctype="multipart/form-data" class="needs-validation" method="GET" action="api/geo.php" id="postAds" novalidate>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 ps-0 my-1">
                                <p class="text-bg-white" style="--bs-text-opacity: .9;">To continue creating ads please fill up your property address below.</p>
                            </div>
                            <div class="col-md-4 ps-0 mb-3">
                                <label class="form-label">Street/Road</label>
                                <input type="text" name="inp_street" id="street_input" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Street/Road is require.
                                </div>
                            </div>
                            <div class="col-md-4 ps-0 mb-3">
                                <label class="form-label">Village/Area</label>
                                <input type="text" name="inp_area" id="area_input" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Village/Area is require.
                                </div>
                            </div>
                            <div class="col-md-4 p-0 mb-3">
                                <label class="form-label">Police Station</label>
                                <input type="text" name="inp_ps" id="ps_input" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Police Station is require.
                                </div>
                            </div>
                            <div class="col-md-4 ps-0 mb-3">
                                <label class="form-label">District</label>
                                <input type="text" name="inp_district" id="district_input" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    District is require.
                                </div>
                            </div>
                            <div class="col-md-4 ps-0  mb-3">
                                <label class="form-label">Division</label>
                                <input type="text" name="inp_division" id="division_input" class="form-control shadow-none" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Division is require.
                                </div>
                            </div>
                            <div class="col-md-4 p-0  mb-3">
                                <label class="form-label">Zip Code</label>
                                <input type="number" name="inp_zip" id="zip_input" class="form-control shadow-none" maxlength="6"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Zip Code is require.
                                </div>
                            </div>
                            <div class="col-12 mb-lg-3 mb-2 text-center">
                                <button class="btn btn-primary shadow-none" name="createPost" type="submit">Continue</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>