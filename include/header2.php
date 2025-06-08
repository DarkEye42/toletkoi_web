<?php
$contact_sql = "SELECT * FROM `sitedata` WHERE `id`=?";
//$contact_result = mysqli_fetch_assoc(select($contact_sql, [1], "i"));
$contact_result = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `sitedata` WHERE `id`=1"));

if (isset($_SESSION["userLogin"]) && $_SESSION["userLogin"] == true) {
    $user_sql = "SELECT * FROM `users` WHERE `id`=?";
    //$user_result = mysqli_fetch_assoc(select($user_sql, [$_SESSION["id"]], "i"));
    $user_result = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `users` WHERE `id`=" . $_SESSION["id"] . ""));
    $isVerified = $user_result['is_email_verified'];
    //$col_size = ($isVerified) ? "col-6" : "col-8";
}
$col_size = (isset($_SESSION["userLogin"]) && $_SESSION["userLogin"] == true && $isVerified != 1) ? "col-6" : "col-8";
?>

<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<?php
if (isset($_SESSION["post"])) {
    if ($_SESSION["post"] == "success") {
        alert("success", "Successfully posted the ad!");
        unset($_SESSION["post"]);
    } elseif ($_SESSION["post"] == "error") {
        alert("error", "Ads not posted!");
        unset($_SESSION["post"]);
    }
}
?>
<!-- Navbar Start -->
<header class="mb-5">
    <div class="header-top">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="admin/images/logo.png" alt="Logo" style="height: 40px !important;"></a>
            </div>
            <div class="header-top-right">

                <div class="dropdown">
                    <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar avatar-md2">
                            <img src="files/<?=$user_result['avatar']?>" alt="<?=$user_result['first_name'].' '.$user_result['last_name']?>">
                        </div>
                        <div class="text">
                            <h6 class="user-dropdown-name"><?=$user_result['first_name'].' '.$user_result['last_name']?></h6>
                            <p class="user-dropdown-status text-sm text-muted"><?=$user_result['is_owner'] > 0 ? 'House Owner' : 'Renter';?></p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown" style="">
                        <li><a class="dropdown-item menu-link" href="<?=$user_result['is_owner'] > 0 ? 'rentalOwner.php' : '#';?>">Dashboard</a></li>
                        <li><a class="dropdown-item menu-link" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item menu-link" href="logout.php">Logout</a></li>
                    </ul>
                </div>

                <!-- Burger button responsive -->
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </div>
        </div>
    </div>
    <nav class="main-navbar shadow-sm">
        <div class="container">
            <ul>
                <li class="menu-item  ">
                    <a href="renterOwner.php" class="menu-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item  has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-stack"></i>
                        <span>Components</span>
                    </a>
                    <div class="submenu ">
                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item  ">
                                    <a href="component-alert.html" class="submenu-link">Alert</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-badge.html" class="submenu-link">Badge</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-breadcrumb.html" class="submenu-link">Breadcrumb</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-button.html" class="submenu-link">Button</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-card.html" class="submenu-link">Card</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-carousel.html" class="submenu-link">Carousel</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-collapse.html" class="submenu-link">Collapse</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-dropdown.html" class="submenu-link">Dropdown</a>
                                </li>
                            </ul>
                            <ul class="submenu-group">
                                <li class="submenu-item  ">
                                    <a href="component-list-group.html" class="submenu-link">List Group</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-modal.html" class="submenu-link">Modal</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-navs.html" class="submenu-link">Navs</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-pagination.html" class="submenu-link">Pagination</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-progress.html" class="submenu-link">Progress</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-spinner.html" class="submenu-link">Spinner</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="component-tooltip.html" class="submenu-link">Tooltip</a>
                                </li>
                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Extra Components</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">
                                        <li class="subsubmenu-item ">
                                            <a href="extra-component-avatar.html" class="subsubmenu-link">Avatar</a>
                                        </li>

                                        <li class="subsubmenu-item ">
                                            <a href="extra-component-sweetalert.html" class="subsubmenu-link">Sweet Alert</a>
                                        </li>

                                        <li class="subsubmenu-item ">
                                            <a href="extra-component-toastify.html" class="subsubmenu-link">Toastify</a>
                                        </li>

                                        <li class="subsubmenu-item ">
                                            <a href="extra-component-rating.html" class="subsubmenu-link">Rating</a>
                                        </li>

                                        <li class="subsubmenu-item ">
                                            <a href="extra-component-divider.html" class="subsubmenu-link">Divider</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>



                <li class="menu-item active has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Layouts</span>
                    </a>
                    <div class="submenu ">
                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">

                                <li class="submenu-item  ">
                                    <a href="layout-default.html" class="submenu-link">Default Layout</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="layout-vertical-1-column.html" class="submenu-link">1 Column</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="layout-vertical-navbar.html" class="submenu-link">Vertical Navbar</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="layout-rtl.html" class="submenu-link">RTL Layout</a>
                                </li>
                                <li class="submenu-item active ">
                                    <a href="layout-horizontal.html" class="submenu-link">Horizontal Menu</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </li>

                <li class="menu-item  has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Forms</span>
                    </a>
                    <div class="submenu ">
                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">

                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Form Elements</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">

                                        <li class="subsubmenu-item ">
                                            <a href="form-element-input.html" class="subsubmenu-link">Input</a>
                                        </li>

                                        <li class="subsubmenu-item ">
                                            <a href="form-element-input-group.html" class="subsubmenu-link">Input Group</a>
                                        </li>

                                        <li class="subsubmenu-item ">
                                            <a href="form-element-select.html" class="subsubmenu-link">Select</a>
                                        </li>

                                        <li class="subsubmenu-item ">
                                            <a href="form-element-radio.html" class="subsubmenu-link">Radio</a>
                                        </li>

                                        <li class="subsubmenu-item ">
                                            <a href="form-element-checkbox.html" class="subsubmenu-link">Checkbox</a>
                                        </li>

                                        <li class="subsubmenu-item ">
                                            <a href="form-element-textarea.html" class="subsubmenu-link">Textarea</a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="form-layout.html" class="submenu-link">Form Layout</a>
                                </li>
                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Form Validation</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">
                                        <li class="subsubmenu-item ">
                                            <a href="form-validation-parsley.html" class="subsubmenu-link">Parsley</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Form Editor</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">
                                        <li class="subsubmenu-item ">
                                            <a href="form-editor-quill.html" class="subsubmenu-link">Quill</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="form-editor-ckeditor.html" class="subsubmenu-link">CKEditor</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="form-editor-summernote.html" class="subsubmenu-link">Summernote</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="form-editor-tinymce.html" class="subsubmenu-link">TinyMCE</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="menu-item  has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-table"></i>
                        <span>Table</span>
                    </a>
                    <div class="submenu ">
                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item  ">
                                    <a href="table.html" class="submenu-link">Table</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="table-datatable.html" class="submenu-link">Datatable</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="table-datatable-jquery.html" class="submenu-link">Datatable (jQuery)</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="menu-item  has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-plus-square-fill"></i>
                        <span>Extras</span>
                    </a>
                    <div class="submenu ">
                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Widgets</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">
                                        <li class="subsubmenu-item ">
                                            <a href="ui-widgets-chatbox.html" class="subsubmenu-link">Chatbox</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="ui-widgets-pricing.html" class="subsubmenu-link">Pricing</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="ui-widgets-todolist.html" class="subsubmenu-link">To-do List</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Icons</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">
                                        <li class="subsubmenu-item ">
                                            <a href="ui-icons-bootstrap-icons.html" class="subsubmenu-link">Bootstrap Icons </a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="ui-icons-fontawesome.html" class="subsubmenu-link">Fontawesome</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="ui-icons-dripicons.html" class="subsubmenu-link">Dripicons</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Charts</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">
                                        <li class="subsubmenu-item ">
                                            <a href="ui-chart-chartjs.html" class="subsubmenu-link">ChartJS</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="ui-chart-apexcharts.html" class="subsubmenu-link">Apexcharts</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </div>
                    </div>
                </li>
                <li class="menu-item  has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-file-earmark-fill"></i>
                        <span>Pages</span>
                    </a>
                    <div class="submenu ">
                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Authentication</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">
                                        <li class="subsubmenu-item ">
                                            <a href="auth-login.html" class="subsubmenu-link">Login</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="auth-register.html" class="subsubmenu-link">Register</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="auth-forgot-password.html" class="subsubmenu-link">Forgot Password</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Errors</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">
                                        <li class="subsubmenu-item ">
                                            <a href="error-403.html" class="subsubmenu-link">403</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="error-404.html" class="subsubmenu-link">404</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="error-500.html" class="subsubmenu-link">500</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="submenu-item  ">
                                    <a href="ui-file-uploader.html" class="submenu-link">File Uploader</a>
                                </li>
                                <li class="submenu-item  has-sub">
                                    <a href="#" class="submenu-link">Maps</a>
                                    <!-- 3 Level Submenu -->
                                    <ul class="subsubmenu">
                                        <li class="subsubmenu-item ">
                                            <a href="ui-map-google-map.html" class="subsubmenu-link">Google Map</a>
                                        </li>
                                        <li class="subsubmenu-item ">
                                            <a href="ui-map-jsvectormap.html" class="subsubmenu-link">JS Vector Map</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="application-email.html" class="submenu-link">Email Application</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="application-chat.html" class="submenu-link">Chat Application</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="application-gallery.html" class="submenu-link">Photo Gallery</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="application-checkout.html" class="submenu-link">Checkout Page</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="menu-item  has-sub">
                    <a href="#" class="menu-link">
                        <i class="bi bi-life-preserver"></i>
                        <span>Support</span>
                    </a>
                    <div class="submenu ">
                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                <li class="submenu-item  ">
                                    <a href="https://zuramai.github.io/mazer/docs" class="submenu-link">Documentation</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="https://github.com/zuramai/mazer/blob/main/CONTRIBUTING.md" class="submenu-link">Contribute</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="https://github.com/zuramai/mazer#donation" class="submenu-link">Donate</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Navbar End -->

<!-- Login Modal -->
<div class="modal fade" id="loginModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="login">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i> Account Login
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control shadow-none">
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <button type="submit" name="login" class="btn btn-dark shadow-none">Login</button>
                        <a href="forgot_password.php" class="text-secondary text-decoration-none">Forgot Password?</a>
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
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $street = $_POST['street'];
    $village = $_POST['village'];
    $policeStation = $_POST['policeStation'];
    $district = $_POST['district'];
    $division = $_POST['division'];
    $zipCode = $_POST['zipCode'];

    $md5_pass = md5($password);
    $village_var = $street . ', ' . $village;
    $joinDate = round(microtime(true) * 1000);
    $dob = strtotime($dateOfBirth) * 1000;

    if ($password == $confirm_password) {
        // Insert data into the "users" table
        $sql = "INSERT INTO users (first_name, last_name, birthDate, email, phone, password, avatar, joinDate, village, policeStation, district, division, zipCode, isUpdated)
        VALUES ('$firstName', '$lastName', '$dob', '$email', '$phone', '$md5_pass', 'user.jpg', '$joinDate', '$village_var', '$policeStation', '$district', '$division', '$zipCode', 0)";

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
<div class="modal fade" id="registerModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form class="needs-validation" action="" method="POST" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title fs-5 d-flex align-items-center">
                        <i class="bi bi-person-lines-fill fs-3 me-2"></i> Account Registration
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge text-bg-light mb-3 text-wrap lh-base">
                        Note: Your given details must match with your ID (NID Card, Passport, or Driving License)
                        that will be required during renting.
                    </span>
                    <div class="container-fluid">
                        <div class="row">
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
                                <input name="phone" type="phone" name="phone" class="form-control shadow-none" placeholder="01XXX-XXXXXX" id="phone" required>
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
                                <button class="btn btn-dark shadow-none" name="register" type="submit">Confirm Register</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ads Post Modal -->
<div class="modal fade" id="createAdsModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 d-flex align-items-center">
                    <i class="bi bi-card-list me-2"></i> Please input your property address
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
                                <input type="number" name="inp_zip" id="zip_input" class="form-control shadow-none" maxlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Zip Code is require.
                                </div>
                            </div>
                            <div class="col-12 mb-lg-3 mb-2 text-center">
                                <button class="btn btn-dark shadow-none" name="createPost" type="submit">Continue</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Preloader -->
<!-- <div class="preloader">
    <div id="preloader-container">
        <div id="preloader-animation"></div>
    </div>
</div> -->