<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Your Information - ToletKoi</title>
    <link rel="stylesheet" href="include/updateInfo.css">
    <?php include('include/commonLinks.php'); ?>
    <link rel="stylesheet" href="include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style type="text/css">
        .about-me {
            resize: none;
            line-height: 1;
            max-lines: 4;
            min-height: calc(5.5em + 0.75rem + 2px) !important;
        }
    </style>
</head>

<body>
    <div id="app">
        <?php
            require("admin/include/db_config.php");
            require("admin/include/essentials.php");
            include('include/sidebar2.php');

            if (isset($_SESSION["updateInfo"]) && $_SESSION['updateInfo'] == false){
                alert('error', 'Please update your information first to continue.');
                unset($_SESSION["updateInfo"]);
            }

            if(!isset($_SESSION['id'])){
                $_SESSION['error'] = 'NotLoggedIn';
                redirect('index.php');
            }

            if(isset($_POST['submit'])){

                // Validate and sanitize all input fields
                $username = validateInput($_POST["username"]);
                $phone = validateInput($_POST["phone"]);
                $profession = validateInput($_POST["profession"]);
                $company = validateInput($_POST["company"]);
                $aboutMe = validateInput($_POST["aboutMe"]);
                $nid = validateInput($_POST["nid"]);
                $dob = validateInput($_POST["dob"]);
                $gender = validateInput($_POST["gender"]);
                $village = validateInput($_POST["village"]);
                $zip = validateInput($_POST['zip']);
                $ps_var = validateInput($_POST['area']);
                $dis_var = validateInput($_POST['district']);
                $div_var = validateInput($_POST['division']);

                $uploadedImagePath = 'user.jpg'; // Default image path

                if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $uploadedImagePath = uploadAvatar($_FILES['file']['tmp_name'], 'images/avatars/');
                }

                // Check if any required fields are empty
                if (empty($username) || empty($phone) || empty($profession) || empty($company) || empty($aboutMe) ||
                    empty($nid) || empty($dob) || empty($gender) || empty($village) || empty($zip) ||
                    empty($ps_var) || empty($dis_var) || empty($div_var)) {
                    alert('error', 'All fields are required.');
                } else {

                    $sql_1 = "SELECT * FROM upazilas WHERE id = '$ps_var'";
                    $result_1 = mysqli_query($con, $sql_1);
                    $thana_name = mysqli_fetch_array($result_1);

                    $sql_2 = "SELECT * FROM districts WHERE id = '$dis_var'";
                    $result_2 = mysqli_query($con, $sql_2);
                    $district_name = mysqli_fetch_array($result_2);

                    $sql_3 = "SELECT * FROM  divisions WHERE id = '$div_var'";
                    $result_3 = mysqli_query($con, $sql_3);
                    $division_name = mysqli_fetch_array($result_3);

                    // Updating the user information
                    $division = validateInput($division_name['name']);
                    $district = validateInput($district_name['name']);
                    $area = validateInput($thana_name['name']);
                    $village = validateInput($_POST["village"]);

                    $address_var = $village . ", " . $thana_name['name']  . ", " . $district_name['name']  . ", " . $division_name['name'] . " - " . $_POST['zip'];

                    $geocode = httpPost(
                        'https://barikoi.xyz/v1/api/search/NDQ4NTpUNU5PNTBKOVZJ/rupantor/geocode',
                        [
                            "q" => $address_var,
                            "bangla" => "yes",
                            "thana" => "yes",
                            "district" => "yes"
                        ]
                    );
        
                    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

                    $checkMessage = dataExist($phone, $nid, $username);

                    if (!empty($checkMessage)) {
                        alert('error', $checkMessage);
                    } else {
                        $sql = "UPDATE users SET
                                username = :username,
                                phone = :phone,
                                profession = :profession,
                                company = :company,
                                aboutMe = :aboutMe,
                                avatar = :avatar,
                                nidNumber = :nid,
                                birthDate = :dob,
                                gander = :gender,
                                division = :division,
                                district = :district,
                                policeStation = :area,
                                village = :village,
                                zipCode = :zip,
                                latitude = :latitude,
                                longitude = :longitude,
                                isUpdated = 1
                                WHERE id = :user_id";
            
                        $stmt = $pdo->prepare($sql);
            
                        $stmt->bindParam(":username", $username);
                        $stmt->bindParam(":phone", $phone);
                        $stmt->bindParam(":profession", $profession);
                        $stmt->bindParam(":company", $company);
                        $stmt->bindParam(":aboutMe", $aboutMe);
                        $stmt->bindParam(":avatar", $uploadedImagePath);
                        $stmt->bindParam(":nid", $nid);
                        $stmt->bindParam(":dob", $dob);
                        $stmt->bindParam(":gender", $gender);
                        $stmt->bindParam(":division", $division);
                        $stmt->bindParam(":district", $district);
                        $stmt->bindParam(":area", $area);
                        $stmt->bindParam(":village", $village);
                        $stmt->bindParam(":zip", $zip);
                        $stmt->bindParam(":latitude", $geocode["latitude"]);
                        $stmt->bindParam(":longitude", $geocode["longitude"]);
                        $stmt->bindParam(":user_id", $user_id);
            
                        if ($stmt->execute()) {
                            $_SESSION['updateInfo'] = true;
                            redirect('index.php');
                        } else {
                            alert('error', 'Update failed. Something wanting wrong!');
                        }
                    }
                }
            }

        
            function validateInput($input) {
                // You can implement your own validation logic here
                $input = trim($input);
                $input = htmlspecialchars($input);
                return $input;
            }
        ?>
        <!-- Main Section Start -->
        <div id="main" class="layout-navbar">
            <header class="mb-3 sticky-top bg-white">
                <?php include('include/navbar.php') ?>
            </header>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Form START -->
                        <form class="file-upload" method="POST">
                            <div class="row mb-5 gx-5">
                                <!-- Contact detail -->
                                <div class="col-xxl-8 mb-5 mb-xxl-0">
                                    <div class="bg-secondary-soft px-4 py-2 rounded">
                                        <div class="row g-3">
                                            <h4 class="mb-2 mt-0">Basic Information</h4>
                                            <!-- Username number -->
                                            <div class="col-md-6">
                                                <label class="form-label">User Name *</label>
                                                <input type="text" class="form-control" name="username" placeholder="Username" aria-label="User Name" required>
                                            </div>
                                            <!-- Phone number -->
                                            <div class="col-md-6">
                                                <label class="form-label">Phone number *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">+88</span>
                                                    <input type="text" class="form-control" name="phone" placeholder="01XXXXXXXXX" aria-label="Phone number" required>
                                                </div>
                                            </div>
                                            <!-- Profession -->
                                            <div class="col-md-6">
                                                <label class="form-label">Profession *</label>
                                                <input type="text" class="form-control" name="profession" placeholder="Profession" aria-label="Profession" required>
                                            </div>
                                            <!-- Company -->
                                            <div class="col-md-6">
                                                <label for="company" class="form-label">Company *</label>
                                                <input type="text" class="form-control" name="company" id="company" placeholder="Company Name" required>
                                            </div>
                                            <!-- About Me -->
                                            <div class="col-12">
                                                <label for="aboutMe" class="form-label">About Me (Max: 240)*</label>
                                                <textarea type="text" name="aboutMe" class="form-control about-me" id="aboutMe" maxlength="240" required></textarea>
                                            </div>
                                            <h4 class="mt-3 mb-1">Personal Detail</h4>
                                            <!-- NID -->
                                            <div class="col-md-6">
                                                <label class="form-label">NID, Birth Certificate or Driving License No</label>
                                                <input type="text" class="form-control" name="nid" placeholder="" aria-label="Nid number" required>
                                            </div>
                                            <!-- Birth Date -->
                                            <div class="col-md-6">
                                                <label class="form-label">Birth Date *</label>
                                                <input type="date" name="dob" class="form-control" placeholder="" aria-label="Phone number" required>
                                            </div>
                                            <!-- Gander -->
                                            <div class="col-md-6">
                                                <label class="form-label">Gender *</label>
                                                <select class="form-select form-select mb-3" name="gender" aria-label="Large select example" required>
                                                    <option selected>Select Gander</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>

                                            <h4 class="mt-3 mb-2">Address Detail <code>*</code></h4>
                                            <div class="row g-1">
                                                <div class="row row-cols-1 row-cols-md-5 g-1">
                                                    <div class="form-floating col">
                                                        <select class="form-select" name="division" id="division" required>
                                                            <option value="">Select Division</option>
                                                            <?php echo load_division(); ?>
                                                        </select>
                                                        <label for="division" style="left: unset;">Division</label>
                                                    </div>

                                                    <div class="form-floating col">
                                                        <select class="form-select" name="district" id="district" required>
                                                            <option value="">Select District</option>
                                                        </select>
                                                        <label for="division" style="left: unset;">District</label>
                                                    </div>

                                                    <div class="form-floating col">
                                                        <select class="form-select" name="area" id="area" required>
                                                            <option value="">Select Thana</option>
                                                        </select>
                                                        <label for="area" style="left: unset;">Thana</label>
                                                    </div>

                                                    <div class="form-floating col">
                                                        <input type="text" class="form-control" placeholder="Village" name="village" id="village" required>
                                                        <label for="village">Village</label>
                                                    </div>

                                                    <div class="form-floating col">
                                                        <input type="text" class="form-control" placeholder="Zip Code" name="zip" id="zip" required>
                                                        <label for="zip">Zip Code</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- Row END -->
                                    </div>
                                </div>
                                <!-- Upload profile -->
                                <div class="col-xxl-4">
                                    <div class="bg-secondary-soft px-4 py-2 rounded">
                                        <div class="row g-3">
                                            <h4 class="mb-1 mt-0 text-center">Upload your profile photo</h4>
                                            <div class="text-center">
                                                <!-- Image upload -->
                                                <div class="square position-relative display-2 mb-3">
                                                    <i class="fas fa-fw fa-user position-absolute top-50 start-50 translate-middle text-secondary"></i>
                                                </div>
                                                <!-- Button -->
                                                <div class="row px-3">
                                                    <div class="col-6">
                                                        <input type="file" id="File" name="file" hidden="">
                                                        <label class="btn btn-sm btn-outline-success w-100" for="File">Upload</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-outline-danger w-100">Remove</button>
                                                    </div>
                                                </div>
                                                <!-- Content -->
                                                <p class="text-muted mt-3 mb-0"><span class="me-1">Note:</span>Please try to provide your update and real photo to get more engagements.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Row END -->
                            <!-- button -->
                            <div class="gap-3 d-md-flex justify-content-md-start text-center mx-4">
                                <input type="submit" name="submit" value="Update Info" class="btn btn-primary btn-lg">
                                <a href="index.php" type="button" class="btn btn-danger btn-lg">Chancel</a>
                            </div>
                        </form> <!-- Form END -->
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
        <!-- Main Section End -->
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/essential.js"></script>
</body>

</html>