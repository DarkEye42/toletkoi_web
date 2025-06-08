<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RentalOrb - Biggest home rental service in Bangladesh</title>
    <?php include('include/commonLinks.php') ?>
    <link rel="stylesheet" href="include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="assets/extensions/quill/quill.snow.css">
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
                    <?php
                            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
                            $host = $_SERVER['HTTP_HOST'];
                            $uri = $_SERVER['REQUEST_URI'];
                            $fullUrl = $protocol . $host . $uri;

                            // User & Ads Authorizations
                            if (isset($_GET['ads'])){
                                $adsID = $_GET['ads'];
                                $adsQuery = "SELECT * FROM rentalposts WHERE id = $adsID";
                                $adsResult = $con->query($adsQuery);
                                $row = $adsResult->fetch_assoc();

                            } else {
                                $_SESSION['error'] = 'adsId-NotFound';
                                redirect('rentalOwner.php');
                            }

                            if($row['post_owner'] != $_SESSION['id'] && isset($_SESSION['id'])){
                                $_SESSION['error'] = 'post_owner-NotMatched';
                                if($_SESSION['is_owner']){
                                    redirect('rentalOwner.php');
                                }
                                
                            } else if(!isset($_SESSION['id'])){
                                $_SESSION['error'] = 'NotLoggedIn';
                                redirect('index.php');
                            }
                            
                        ?>
                        <div class="col-lg-9 mt-2">
                            <!-- Ads Post Modal -->
                            <div class="col-lg-12">
                                <div class="card shadow bg-white border-0 my-3">
                                    <div class="card-header">
                                            <h5 class="card-title fs-5 d-flex align-items-center">
                                            <i class="bi bi-card-list me-2"></i> Create A Rental Post
                                            </h5>
                                        </div>
                                    <div class="card-body card-body-hover">
                                        <form enctype="multipart/form-data" class="needs-validation" action="<?= $fullUrl; ?>" method="POST" id="postAds" novalidate>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    
                                                    <div class="col-md-12 ps-0 my-1">
                                                        <p class="text-bg-white fs-5" style="--bs-text-opacity: .9;">Rental Info</p>
                                                    </div>
                                                    <div class="col-md-12 ps-0 mb-3">
                                                        <label class="form-label">Ads Title <span style="font-size: smaller;">(Max: 120 letter)</span></label>
                                                        <input type="text" class="form-control shadow-none" name="inp_title" value="<?= $row['title'] ?>" id="title_input" placeholder="2 Room's flat in a cheap cost" maxlength="120" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ads title is require.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 p-0 mb-3 h-100">
                                                        <label class="form-label">Description <span style="font-size: smaller;">(Max: 240 letter)</span></label>
                                                        <div id="snow">
                                                            <?= $row['description'] ?>
                                                        </div>
                                                        <input type="hidden" name="inp_description" id="description_input" value="<p>Example Description!</p><p>Some initial <strong>bold</strong> description text</p>" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Description is require.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">Expected Renters</label>
                                                        <select class="form-select shadow-none" name="inp_renterType" id="renterType_input" size="3" aria-label="multiple select" required>
                                                            <option value="Any Renters">Both Rentals</option>
                                                            <option selected value="Families">Only Families</option>
                                                            <option value="Bachelors">Only Bachelors</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 p-0 mb-3">
                                                        <label class="form-label">Allowed For Apply</label>
                                                        <select class="form-select shadow-none" name="inp_apply" id="apply_input" size="3" aria-label="multiple select" required>
                                                            <option value="Both">Both Gender</option>
                                                            <option selected value="Male">Only Male</option>
                                                            <option value="Female">Only Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">Building Type <span style="font-size: smaller;">(Ex: Flat House)</span></label>
                                                        <select class="form-select shadow-none" name="inp_building" id="building_input" aria-label="multiple select" required>
                                                            <option selected value="Tinned House">Tinned House</option>
                                                            <option value="Half Building">Half Building</option>
                                                            <option value="Flat House">Flat House</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">Expected Renting Date</label>
                                                        <input type="date" name="inp_rentDate" id="rentDate_input" class="form-control shadow-none" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Renting Date is require.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 ps-0 my-1">
                                                        <p class="text-bg-white fs-5" style="--bs-text-opacity: .9;">Facilities</p>
                                                    </div>
                                                    <div class="col-md-12 ps-0 mb-3">
                                                        <label class="form-label">Select the available facilities</label>
                                                        <div class="row d-flex justify-content-between ms-2">
                                                            <div class="col-md-6 ps-0 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="inp_electricity" id="electricity_input" type="checkbox" onclick="changeId('electricity_input')" value="Yes" id="flexCheckElectricity" checked>
                                                                    <label class="form-check-label" for="flexCheckElectricity">
                                                                        Electricity
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="inp_water" id="water_input" type="checkbox" onclick="changeId('water_input')" value="Yes" id="flexCheckWater" checked>
                                                                    <label class="form-check-label" for="flexCheckWater">
                                                                        Water
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="inp_gas" id="gas_input" type="checkbox" onclick="changeId('gas_input')" value="No" id="flexCheckGas">
                                                                    <label class="form-check-label" for="flexCheckGas">
                                                                        Gas
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 ps-0 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="inp_internet" id="internet_input" type="checkbox" onclick="changeId('internet_input')" value="No" id="flexCheckInternet">
                                                                    <label class="form-check-label" for="flexCheckInternet">
                                                                        Internet
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="inp_ac" id="ac_input" type="checkbox" onclick="changeId('ac_input')" value="No" id="flexCheckAC">
                                                                    <label class="form-check-label" for="flexCheckAC">
                                                                    Air-Conditioner
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="inp_elevator" id="elevator_input" type="checkbox" onclick="changeId('elevator_input')" value="No" id="flexCheckElevator">
                                                                    <label class="form-check-label" for="flexCheckElevator">
                                                                        Elevator
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 ps-0 my-1">
                                                        <p class="text-bg-white fs-5" style="--bs-text-opacity: .9;">Features</p>
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">How many bedrooms have? <span style="font-size: smaller;">(Ex: 2 Rooms)</span></label>
                                                        <select class="form-select shadow-none" name="inp_bedroom" id="bedroom_input" aria-label="multiple select" required>
                                                            <option value="1">01 Room</option>
                                                            <option value="2">02 Rooms</option>
                                                            <option value="3">03 Rooms</option>
                                                            <option value="4">04 Rooms</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">How many bathroom have? <span style="font-size: smaller;">(Ex: 2 Bathrooms)</span></label>
                                                        <select class="form-select shadow-none" name="inp_bathroom" id="bathroom_input" aria-label="multiple select" required>
                                                            <option value="1">No Bathroom</option>
                                                            <option value="1">01 Bathroom</option>
                                                            <option value="2">02 Bathrooms</option>
                                                            <option value="3">03 Bathrooms</option>
                                                            <option value="4">04 Bathrooms</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">How many balcony have? <span style="font-size: smaller;">(Ex: 1 Balcony)</span></label>
                                                        <select class="form-select shadow-none" name="inp_balcony" id="balcony_input" aria-label="multiple select" required>
                                                            <option value="0">No Balcony</option>
                                                            <option value="1">01 Balcony</option>
                                                            <option value="2">02 Balconys</option>
                                                            <option value="3">03 Balconys</option>
                                                            <option value="4">04 Balconys</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <p class="form-label mb-3">Do you have other features?</p>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" name="inp_kitchen" id="kitchen_input" type="checkbox" onclick="changeId('kitchen_input')" value="No" id="flexCheckKitchen">
                                                            <label class="form-check-label" for="flexCheckKitchen">
                                                                Kitchen
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" name="inp_drawing" id="drawing_input" type="checkbox" onclick="changeId('drawing_input')" value="No" id="flexCheckDrawing">
                                                            <label class="form-check-label" for="flexCheckDrawing">
                                                                Drawing Room
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 ps-0 my-1">
                                                        <p class="text-bg-white fs-5" style="--bs-text-opacity: .9;">Contact &amp; Costing</p>
                                                    </div>
                                                    <div class="col-md-6 p-0 mb-3">
                                                        <label class="form-label">Contact Number</label>
                                                        <input type="number" name="inp_contact" value="<?= $row['contact'] ?>" id="contact_input" class="form-control shadow-none" style="width: 97.5%;" placeholder="01XXXXXXXXX" maxlength="11"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Contact Number is require.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 p-0 mb-3">
                                                        <label class="form-label">Rental Cost per Month</label>
                                                        <input type="number" name="inp_cost" id="cost_input" value="<?= $row['cost'] ?>" class="form-control shadow-none" style="width: 97.5%;" placeholder="5000" maxlength="8"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Costing per month is require.
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-lg-3 mb-2 text-center">
                                                        <input class="btn btn-outline-success shadow-none" name="createPost" type="submit" value="Update This Ads">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
    <script src="assets/extensions/quill/quill.min.js"></script>
    <script>
        var quill = new Quill('#snow', {
            theme: 'snow'
        });

        quill.on('text-change', function () {
            var content = quill.root.innerHTML;
            document.getElementById('description_input').value = content;
        });
    </script>
</body>

</html>