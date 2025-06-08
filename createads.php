<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RentalOrb - Biggest home rental service in Bangladesh</title>
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

        // Redirect user to the home page if not logged in
        if(isset($_SESSION['id'])){
            $post_owner_ = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        } else {
            $_SESSION['error'] = 'NotLoggedIn';
            redirect('index.php');
        }

        // Check if files were uploaded
        if (isset($_POST['submit_property']) && (isset($_FILES['imageFiles']['name']) && count($_FILES['imageFiles']['name']) > 0)) {
            $file_paths = array();

            $street_var = $_POST['house_no'];
            $area_var = $_POST['sector_no'];
            $ps_var = $_POST['area'];
            $dis_var = $_POST['district'];
            $div_var = $_POST['division'];

            $sql_1 = "SELECT * FROM upazilas WHERE id = '$ps_var'";
            $result_1 = mysqli_query($con, $sql_1);
            $thana_name = mysqli_fetch_array($result_1);

            $sql_2 = "SELECT * FROM districts WHERE id = '$dis_var'";
            $result_2 = mysqli_query($con, $sql_2);
            $district_name = mysqli_fetch_array($result_2);

            $sql_3 = "SELECT * FROM  divisions WHERE id = '$div_var'";
            $result_3 = mysqli_query($con, $sql_3);
            $division_name = mysqli_fetch_array($result_3);

            $address_var = $street_var  . "," . $area_var  . "," . $thana_name['name']  . "," . $district_name['name']  . "," . $division_name['name'];

            $geocode = httpPost(
                'https://barikoi.xyz/v1/api/search/NDQ4NTpUNU5PNTBKOVZJ/rupantor/geocode',
                [
                    "q" => $address_var,
                    "bangla" => "yes",
                    "thana" => "yes",
                    "district" => "yes"
                ]
            );

            // Rand Ads ID
            $randId = randomString(12);
            // Loop through the uploaded files
            for ($i = 0; $i < count($_FILES['imageFiles']['name']); $i++) {
                $file_name = $_FILES['imageFiles']['name'][$i];
                $file_tmp = $_FILES['imageFiles']['tmp_name'][$i];
                $file_type = $_FILES['imageFiles']['type'][$i];

                // Check if it's a valid image file
                $allowed_extensions = array('jpeg', 'jpg', 'png');
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                    continue; // Skip non-image files
                }

                // Resize and convert to webp
                $resized_image = resizeImage($file_tmp, 300, 300);
                $current_time = date("YmdHis");
                $webp_image = imagecreatefromstring($resized_image);
                $webp_filename = uniqid() . "_" . $current_time . ".webp";
                imagewebp($webp_image, "files/images/post/" . $webp_filename, 80); // Adjust quality (0-100) as needed
                $filePath = 'files/images/post/' . $webp_filename;

                // Save the webp file path in the database
                $stmt = $pdo->prepare("INSERT INTO postimages (path, ads_id) VALUES (:filePath_var, :adsID)");
                $stmt->bindParam(':filePath_var', $filePath);
                $stmt->bindParam(':adsID', $randId);
                $stmt->execute();

                // Store the file path in an array
                $file_paths[] = "files/images/post/$webp_filename";
            }

            // Data Hookups
            $description_ = $_POST['description'];
            $category_ = $_POST['property_category'];
            $takeOver_ = $_POST['month'];
            $shortAddress_ = $_POST['place'];
            $street_ = $_POST['sector_no'] != null ? $_POST['sector_no'] : null;
            $house_no_ = $_POST['house_no'] != null ? $_POST['house_no'] : null;
            $policeStation_ = $thana_name['name'];
            $district_ = $district_name['name'];
            $division_ = $division_name['name'];
            $cost_ = $_POST['price'];
            $negotiable_ = isset($_POST['inp_negotiable']) ? 1 : 0;
            $price_type_ = $_POST['price_type'];
            $building_type_ = $_POST['property_type'];
            $size_ = $_POST['size'] != null ? $_POST['size'] : null;
            $latitude_ = $geocode["latitude"];
            $longitude_ = $geocode["longitude"];
            $electricity_ = isset($_POST['inp_electricity']) ? 'yes' : 'no';
            $water_ = isset($_POST['inp_water']) ? 'yes' : 'no';
            $gas_ = isset($_POST['inp_gas']) ? 'yes' : 'no';
            $internet_ = isset($_POST['inp_internet']) ? 'yes' : 'no';
            $ac_ = isset($_POST['inp_ac']) ? 'yes' : 'no';
            $elevator_ = isset($_POST['inp_elevator']) ? 'yes' : 'no';
            $cc_cam_ = isset($_POST['inp_cc_cam']) ? 'yes' : 'no';
            $parking_ = isset($_POST['inp_parking']) ? 'yes' : 'no';
            $security_ = isset($_POST['inp_security']) ? 'yes' : 'no';
            $electricity_bill_ = isset($_POST['inp_electricity_bill']) ? 'yes' : 'no';
            $gas_bill_ = isset($_POST['inp_gas_bill']) ? 'yes' : 'no';
            $water_bill_ = isset($_POST['inp_water_bill']) ? 'yes' : 'no';
            $lift_bill_ = isset($_POST['inp_lift_bill']) ? 'yes' : 'no';
            $security_bill_ = isset($_POST['inp_security_bill']) ? 'yes' : 'no';
            $floor_ = $_POST['floor'];
            $rooms_ = $_POST['bedroom'];
            $bathroom_ = $_POST['bathroom'];
            $balcony_ = isset($_POST['balcony']) ? $_POST['balcony'] : 0;
            $kitchen_ = $_POST['kitchen'];

            // Save the webp file path in the database
            $stmt = $pdo->prepare("INSERT INTO rentalposts (uniqueId, post_owner, description, category, takeOver,
                shortAddress, street, house_no, policeStation, district, division, cost, negotiable, cost_type, building_type, floorSize,
                latitude, longitude, electricity, water, gas, internet, ac, elevator, cc_camera, parking, security, electricity_bill,
                gas_bill, water_bill, lift_bill, security_bill, floorLevel, rooms, bathroom, balcony, kitchen)
                VALUES (:uniqueId_var, :post_owner_var, :description_var, :category_var, :takeOver_var,
                :shortAddress_var, :street_var, :house_no_var, :policeStation_var, :district_var, :division_var, :cost_var, :negotiable_var, :price_type_var, :building_type_var, :size_var,
                :latitude_var, :longitude_var, :electricity_var, :water_var, :gas_var, :internet_var, :ac_var, :elevator_var, :cc_cam_var, :parking_var, :security_var,
                :electricity_bill_var, :gas_bill_var, :water_bill_var, :lift_bill_var, :security_bill_var, :floor_var, :rooms_var, :bathroom_var, :balcony_var, :kitchen_var)");

            $stmt->bindParam(':uniqueId_var', $randId);
            $stmt->bindParam(':post_owner_var', $post_owner_);
            $stmt->bindParam(':description_var', $description_);
            $stmt->bindParam(':category_var', $category_);
            $stmt->bindParam(':takeOver_var', $takeOver_);
            $stmt->bindParam(':shortAddress_var', $shortAddress_);
            $stmt->bindParam(':street_var', $street_);
            $stmt->bindParam(':house_no_var', $house_no_);
            $stmt->bindParam(':policeStation_var', $policeStation_);
            $stmt->bindParam(':district_var', $district_);
            $stmt->bindParam(':division_var', $division_);
            $stmt->bindParam(':cost_var', $cost_);
            $stmt->bindParam(':negotiable_var', $negotiable_);
            $stmt->bindParam(':price_type_var', $price_type_);
            $stmt->bindParam(':building_type_var', $building_type_);
            $stmt->bindParam(':size_var', $size_);
            $stmt->bindParam(':latitude_var', $latitude_);
            $stmt->bindParam(':longitude_var', $longitude_);
            $stmt->bindParam(':electricity_var', $electricity_);
            $stmt->bindParam(':water_var', $water_);
            $stmt->bindParam(':gas_var', $gas_);
            $stmt->bindParam(':internet_var', $internet_);
            $stmt->bindParam(':ac_var', $ac_);
            $stmt->bindParam(':elevator_var', $elevator_);
            $stmt->bindParam(':cc_cam_var', $cc_cam_);
            $stmt->bindParam(':parking_var', $parking_);
            $stmt->bindParam(':security_var', $security_);
            $stmt->bindParam(':electricity_bill_var', $electricity_bill_);
            $stmt->bindParam(':gas_bill_var', $gas_bill_);
            $stmt->bindParam(':water_bill_var', $water_bill_);
            $stmt->bindParam(':lift_bill_var', $lift_bill_);
            $stmt->bindParam(':security_bill_var', $security_bill_);
            $stmt->bindParam(':floor_var', $floor_);
            $stmt->bindParam(':rooms_var', $rooms_);
            $stmt->bindParam(':bathroom_var', $bathroom_);
            $stmt->bindParam(':balcony_var', $balcony_);
            $stmt->bindParam(':kitchen_var', $kitchen_);

            // Check for PDO errors after query execution
            if ($stmt->execute() === TRUE) {
                //Data inserted successfully!
                $_SESSION['post'] = 'success';
                //redirect('index.php');
            } else {
                //$errorInfo = $stmt->errorInfo();
                //echo "Error: " . $errorInfo[2];
                $_SESSION['post'] = 'error';
                redirect('index.php');
            }
            // Close the database connection
            $pdo = null;

            // Return the image paths as a JSON response
            //echo json_encode($file_paths);

        }
        ?>
        <!-- Main Section Start -->
        <div id="main" class="layout-navbar">
            <header class="mb-3 sticky-top bg-white">
                <?php include('include/navbar.php') ?>
            </header>
            <div id="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <!-- Ads Post Modal -->
                            <form id="formProperty" class="card px-4 py-2" enctype="multipart/form-data" method="POST">
                                    <h6 class="mt-3 mb-2"><i class="bi bi-images"></i> Upload Property Images</h6>
                                    <!-- File uploader with multiple files upload -->
                                    <div class="row">
                                        <div class="col-lg-4 col-12">
                                            <div id="dropArea" class="drop-area">
                                                <input type="file" id="fileInput" name="imageFiles[]" accept="image/*" style="display: none;" multiple required>
                                                <label for="fileInput" class="upload-label w-100 p-3"><i class="bi bi-cloud-arrow-up-fill fw-bold upload-icon"></i><br />Drag & Drop Images or Click to Select Upto 6 Images</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-12">
                                            <div id="selectedItemsTitle" style="display: none;">
                                                <i class="bi bi-file-earmark-richtext"></i> Your selected images are below
                                            </div>
                                            <div id="imagePreview" class="image-preview" style="display: none;">
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="my-2">
                                        <i class="bi bi-info-circle-fill"></i> Basic information
                                    </h6>

                                    <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
                                        <div class="col m-0">
                                            <div class="form-floating mb-3">
                                                <select class="form-select cursor-pointer" id="floatingSelect" name="property_category" required>
                                                    <option value=""> Select Category</option>
                                                    <option value="family"> Family</option>
                                                    <option value="bachelor"> Bachelor</option>
                                                    <option value="office"> Office</option>
                                                    <option value="sublet"> Sublet</option>
                                                    <option value="hostel"> Hostel</option>
                                                    <option value="shop"> Shop</option>
                                                    <option value="factory_place"> Factory Place</option>
                                                    <option value="ready_shed"> Ready Shed</option>
                                                    <option value="open_land"> Open Land</option>
                                                </select>
                                                <label for="floatingSelect">Select Category <code class="fw-bold fs-5">*</code></label>
                                            </div>
                                        </div>
                                        <div class="col m-0">
                                            <div class="form-floating mb-3">
                                                <select class="form-select cursor-pointer" id="floatingSelect" name="property_type" required>
                                                    <option value=""> Select Type</option>
                                                    <option value="house"> House</option>
                                                    <option value="unit"> Unit</option>
                                                    <option value="room"> Room</option>
                                                    <option value="flat"> Flat</option>
                                                    <option value="floor"> Floor</option>
                                                    <option value="apartment"> Apartment</option>
                                                    <option value="semi_building"> Semi Building</option>
                                                    <option value="tinned_house"> Tinned House</option>
                                                    <option value="commercial_place"> Commercial Place</option>
                                                </select>
                                                <label for="floatingSelect">Property type <code class="fw-bold fs-5">*</code></label>
                                            </div>
                                        </div>
                                        <div class="col m-0">
                                            <div class="form-floating mb-3">
                                                <select class="form-select cursor-pointer" id="floatingSelect" name="month" required>
                                                    <option value="">Select month</option>
                                                    <option value="january"> January</option>
                                                    <option value="february"> February</option>
                                                    <option value="march"> March</option>
                                                    <option value="april"> April</option>
                                                    <option value="may"> May</option>
                                                    <option value="june"> June</option>
                                                    <option value="july"> July</option>
                                                    <option value="august"> August</option>
                                                    <option value="september"> September</option>
                                                    <option value="october"> October</option>
                                                    <option value="november"> November</option>
                                                    <option value="december"> December</option>
                                                </select> <label for="floatingSelect">Property available from <code class="fw-bold fs-5">*</code></label>
                                            </div>
                                        </div>
                                        <div class="col m-0">
                                            <div class="form-floating mb-3">
                                                <select class="form-select cursor-pointer" id="floatingSelect" name="bedroom" required>
                                                    <option value="">Select bedroom</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                    <option value="32">32</option>
                                                    <option value="33">33</option>
                                                    <option value="34">34</option>
                                                    <option value="35">35</option>
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38">38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                    <option value="41">41</option>
                                                    <option value="42">42</option>
                                                    <option value="43">43</option>
                                                    <option value="44">44</option>
                                                    <option value="45">45</option>
                                                    <option value="46">46</option>
                                                    <option value="47">47</option>
                                                    <option value="48">48</option>
                                                    <option value="49">49</option>
                                                    <option value="50">50</option>
                                                </select>
                                                <label for="floatingSelect">Bedroom <code class="fw-bold fs-5">*</code></label>
                                            </div>
                                        </div>
                                        <div class="col m-0">
                                            <div class="form-floating mb-3">
                                                <select class="form-select cursor-pointer" id="floatingSelect" name="bathroom" required>
                                                    <option value="">Select bathroom</option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                    <option value="32">32</option>
                                                    <option value="33">33</option>
                                                    <option value="34">34</option>
                                                    <option value="35">35</option>
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38">38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                    <option value="41">41</option>
                                                    <option value="42">42</option>
                                                    <option value="43">43</option>
                                                    <option value="44">44</option>
                                                    <option value="45">45</option>
                                                    <option value="46">46</option>
                                                    <option value="47">47</option>
                                                    <option value="48">48</option>
                                                    <option value="49">49</option>
                                                    <option value="50">50</option>
                                                </select>
                                                <label for="floatingSelect">Bathroom <code class="fw-bold fs-5">*</code></label>
                                            </div>
                                        </div>
                                        <div class="col m-0">
                                            <div class="form-floating mb-3">
                                                <select class="form-select cursor-pointer" id="floatingSelect" name="balcony">
                                                    <option value="0" selected="">Select balcony</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                                <label for="floatingSelect">Balcony</label>
                                            </div>
                                        </div>
                                        <div class="col m-0">
                                            <div class="form-floating mb-3">
                                                <select class="form-select cursor-pointer" id="floatingSelect" name="floor" required>
                                                    <option value="">Select floor</option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                    <option value="32">32</option>
                                                    <option value="33">33</option>
                                                    <option value="34">34</option>
                                                    <option value="35">35</option>
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38">38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                    <option value="41">41</option>
                                                    <option value="42">42</option>
                                                    <option value="43">43</option>
                                                    <option value="44">44</option>
                                                    <option value="45">45</option>
                                                    <option value="46">46</option>
                                                    <option value="47">47</option>
                                                    <option value="48">48</option>
                                                    <option value="49">49</option>
                                                    <option value="50">50</option>
                                                </select>
                                                <label for="floatingSelect">Floor No <small> <code class="fw-bold fs-5">*</code></small></label>
                                            </div>
                                        </div>
                                        <div class="col m-0">
                                            <div class="form-floating mb-3">
                                                <select class="form-select cursor-pointer" id="floatingSelect" name="kitchen" required>
                                                    <option value="">Select kitchen</option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                    <option value="32">32</option>
                                                    <option value="33">33</option>
                                                    <option value="34">34</option>
                                                    <option value="35">35</option>
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38">38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                    <option value="41">41</option>
                                                    <option value="42">42</option>
                                                    <option value="43">43</option>
                                                    <option value="44">44</option>
                                                    <option value="45">45</option>
                                                    <option value="46">46</option>
                                                    <option value="47">47</option>
                                                    <option value="48">48</option>
                                                    <option value="49">49</option>
                                                    <option value="50">50</option>
                                                </select>
                                                <label for="floatingSelect">Kitchen <small> <code class="fw-bold fs-5">*</code></small></label>
                                            </div>
                                        </div>
                                        <div class="col m-0">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floating-input" value="" autocomplete="off" placeholder="Size (sq feet)" name="size">
                                                <label for="floating-input">Size (Sq feet) <small><span class="text-muted">(optional)</span></small></label>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="mb-2">
                                        <i class="bi bi-file-earmark-text-fill"></i> Property Description <code style="font-size: small;">(Contact details and website link not allowed in this section.)</code>
                                    </h6>

                                    <div class="form-floating mb-4">
                                        <textarea class="form-control" name="description" id="description" placeholder="Description" style="height: 150px; resize: none;"></textarea>
                                        <label for="description" style="left: unset;">Write something about your property</label>
                                    </div>

                                    <h6 class="mb-2">
                                        <i class="bi bi-geo-alt-fill"></i> Location Info <span class="text-muted" style="font-size: x-small;">(All fields are required)</span>
                                    </h6>

                                    <div class="col my-2">
                                        <div class="row row-cols-1 row-cols-md-3 g-4">
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

                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floating-input" value="" autocomplete="off" placeholder="House No" name="house_no">
                                                    <label for="floating-input">House/Street</label>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floating-input" value="" autocomplete="off" placeholder="Sector No" name="sector_no">
                                                    <label for="floating-input">Sector No/Area</label>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floating-input" value="" autocomplete="off" placeholder="Village/Road" name="road_no" required>
                                                    <label for="floating-input">Village/Road</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12 mt-2">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floating-input" autocomplete="off" placeholder="Short Address" name="place" value="" required>
                                                    <label for="floating-input">Short address / house name </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="mb-2">
                                        <i class="bi bi-cash-coin"></i> Pricing Details
                                    </h6>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" id="floating-input" value="" autocomplete="off" placeholder="Price" name="price" required>
                                                <label for="floating-input">
                                                    Price
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-6">
                                            <div class="form-floating mb-3">
                                                <select class="form-select cursor-pointer" id="floatingSelect" aria-label="Floating label select example" name="price_type" required>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="daily">Daily</option>
                                                </select>
                                                <label for="floatingSelect">
                                                    Price for <code class="fw-bold fs-5">*</code>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <label class="mb-1 mt-0" for="radio_button">
                                                Select your price is fixed or negotiable:
                                            </label>
                                            <div class="radio" id="radio_button">
                                                <input type="radio" class="radio_input" value="1" name="inp_negotiable" id="negotiable_price" checked>
                                                <label class="radio_label radio_border_right" for="negotiable_price">
                                                    Negotiable
                                                </label>
                                                <input type="radio" class="radio_input" value="0" name="inp_fixed" id="fixed_price">
                                                <label class="radio_label" for="fixed_price">
                                                    Fixed
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="col-md-12 ps-0 my-1">
                                                <div class="form-label fw-bold fs-5">Facilities</div>
                                            </div>
                                            <label class="form-label">Select the available facilities</label>
                                            <div class="row d-flex justify-content-between ms-2">
                                                <div class="col-md-4 ps-0 mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="inp_electricity" id="electricity_input" type="checkbox" id="flexCheckElectricity" checked>
                                                        <label class="form-check-label" for="flexCheckElectricity">
                                                            Electricity
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="inp_water" id="water_input" type="checkbox" id="flexCheckWater" checked>
                                                        <label class="form-check-label" for="flexCheckWater">
                                                            Water
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="inp_gas" id="gas_input" type="checkbox" id="flexCheckGas">
                                                        <label class="form-check-label" for="flexCheckGas">
                                                            Gas
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ps-0 mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="inp_internet" id="internet_input" type="checkbox" id="flexCheckInternet">
                                                        <label class="form-check-label" for="flexCheckInternet">
                                                            Internet
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="inp_ac" id="ac_input" type="checkbox" id="flexCheckAC">
                                                        <label class="form-check-label" for="flexCheckAC">
                                                            Air-Conditioner
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="inp_elevator" id="elevator_input" type="checkbox" id="flexCheckElevator">
                                                        <label class="form-check-label" for="flexCheckElevator">
                                                            Elevator
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ps-0 mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="inp_cc_cam" id="securitycam_input" type="checkbox" id="flexCheckSecurityCam">
                                                        <label class="form-check-label" for="flexCheckSecurityCam">
                                                            Security Camera
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="inp_parking" id="parking_input" type="checkbox" id="flexCheckParking">
                                                        <label class="form-check-label" for="flexCheckParking">
                                                            Parking Garage
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="inp_security" id="security_input" type="checkbox" id="flexCheckSecurity">
                                                        <label class="form-check-label" for="flexCheckSecurity">
                                                            Security Guard
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="mb-3">
                                                <div class="form-label fw-bold fs-5">
                                                    Price included with
                                                </div>
                                                <div>
                                                    <label class="form-check form-check-inline cursor-pointer">
                                                        <input class="form-check-input cursor-pointer" type="checkbox" name="inp_electricity_bill">
                                                        <span class="form-check-label ">Electricy bill</span>
                                                    </label>
                                                    <label class="form-check form-check-inline cursor-pointer">
                                                        <input class="form-check-input cursor-pointer" type="checkbox" name="inp_gas_bill">
                                                        <span class="form-check-label">Gas bill</span>
                                                    </label>
                                                    <label class="form-check form-check-inline cursor-pointer">
                                                        <input class="form-check-input cursor-pointer" type="checkbox" name="inp_water_bill">
                                                        <span class="form-check-label">Water bill</span>
                                                    </label>
                                                    <label class="form-check form-check-inline cursor-pointer">
                                                        <input class="form-check-input cursor-pointer" type="checkbox" name="inp_lift_bill">
                                                        <span class="form-check-label">Lift bill</span>
                                                    </label>
                                                    <label class="form-check form-check-inline cursor-pointer">
                                                        <input class="form-check-input cursor-pointer" type="checkbox" name="inp_security_bill">
                                                        <span class="form-check-label">Security bill</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-footer mx-5 my-4">
                                        <button type="submit" class="btn btn-primary w-100" id="submit_property" name="submit_property">Save Property</button>
                                    </div>
                                </form>
                        </div>

                        <div class="col-lg-3">
                            <div class="card border-0 p-2 rounded shadow-sm" style="position: fixed; margin-right: 2rem;">
                                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                <div class="d-flex justify-content-center">
                                    <lottie-player src="https://assets2.lottiefiles.com/private_files/lf30_u4mgmpw4.json" background="transparent" speed="1" style="max-width: 30%; max-height: 180px" loop autoplay></lottie-player>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <h3>Upgrade to <span class="fw-bold text-info">Pro</span></h3>
                                </div>
                                <div class="text-center text-secondary">
                                    <p>In premium features you can access all the special services. You can promote your rental ads & have unlimited posting advantage.</p>
                                </div>
                                <div class="mx-2" style="font-size: smaller">
                                    <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Unlimited Ads Post.</p>
                                    <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Get Verified Renters or Ads.</p>
                                    <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Verified Nareby Location Access.</p>
                                    <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Get 10 Free Ads Boots per Month.</p>
                                    <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> Get Access of Rental Police From.</p>
                                    <p class="text-secondary fs-6 ms-3"><i class="bi bi-check-circle-fill fw-bold text-success"></i> 24/7 Premium Customer Support.</p>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-info rounded me-lg-3 my-2 text-light" style="border-radius: 50px !important;">Upgrade Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Section End -->
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="include/script.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#division').change(function() {
                var id = $(this).val();
                $.ajax({

                    url: "include/loc_getter_setter.php",
                    method: "POST",
                    data: {
                        divisionId: id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#district').html(data);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#district').change(function() {
                var id = $(this).val();
                $.ajax({
                    url: "include/loc_getter_setter.php",
                    method: "POST",
                    data: {
                        disId: id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#area').html(data);
                    }
                });
            });
        });

        document.getElementById('formProperty').addEventListener('submit', function(event) {
            if (!validateImages()) {
                event.preventDefault();
            }
        });

        function validateImages() {
            const images = document.getElementById('fileInput');

            // Check if any image is not selected
            if (images.files.length === 0) {
                alert('Please select at least 01 image before submitting.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>