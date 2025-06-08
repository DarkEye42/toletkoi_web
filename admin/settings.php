<?php
    require('include/essentials.php');
    require('include/db_config.php');
    adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <?php require('include/commonLinks.php') ?>
</head>
<body class="bg-light">
    
    <?php require('include/header.php') ?>

    <div class="container-fliid" id="main-content">
        <div class="row m-0">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden mt-auto">
                <h3 class="mb-4">SETTINGS</h3>

                <!-- General Settings -->
                <div class="card custom-position">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0">General Settings</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#site-general-settings">
                            <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold mt-2">Site Title</h6>
                        <p class="card-text" id="siteTitle">Loading...!</p>
                        <h6 class="card-subtitle mb-1 fw-bold">About Us</h6>
                        <p class="card-text" id="siteAbout">Loading...!</p>
                    </div>
                </div>

                <!-- General Settings Modal -->
                <div class="modal fade" id="site-general-settings" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="general_settings_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">General Settings</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="from-label mb-2 fw-bold">Site Title</label>
                                        <input type="text" name="site_title" id="siteTitle_input" class="form-control shadow-none w-100" required/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="from-label mb-2 fw-bold">Site About</label>
                                        <textarea name="site_about" id="siteAbout_input" class="form-control shadow-none w-100" rows="6" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary btn-fw" onclick="siteTitle_input.value = general_data.siteTitle, siteAbout_input.value = general_data.siteAbout" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-inverse-warning btn-fw">SAVE CHANGES</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Maintenance Section -->
                <div class="card custom-position mt-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0">Under Maintenance Mode</h5>
                            <div class="form-check form-switch">
                                <form style="display: flex;">
                                    <label class="form-check-label" id="maintenanceTitle" for="maintenanceToggle">Loading...!</label>
                                    <input onchange="upd_maintenance(this.value)" onclick="maintenanceTitle.innerText = maintenance_title_val" id="maintenanceToggle" class="form-check-input" type="checkbox"/>
                                </form>
                            </div>
                        </div>
                        <p class="card-text mt-2" style="font-size: small;">
                            No members can't visit the full website while this mode is on. The website will be going under maintenance mode & all the users will be redirected to the maintenance landing page until the maintenance mode will be turned off.
                        </p>
                    </div>
                </div>

                <!-- Contact Details Section -->
                <div class="card custom-position mt-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0">Contact Settings</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#site-contact-settings">
                            <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold mt-2">Address</h6>
                                    <p class="card-text" id="address">Loading...!</p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold mt-2">Google Map</h6>
                                    <p class="card-text" id="gmap">Loading...!</p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold mt-2">Phone Numbers</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="phn-1">Loading...!</span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="phn-2">Loading...!</span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold mt-2">Email</h6>
                                    <p class="card-text" id="email">Loading...!</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold mt-2">Social Links</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-facebook me-1"></i>
                                        <span id="facebook_link">Loading...!</span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-twitter me-1"></i>
                                        <span id="twitter_link">Loading...!</span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-youtube me-1"></i>
                                        <span id="youtube_link">Loading...!</span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold mt-2">Map iFrame</h6>
                                    <iframe id="iframe" class="border p-2 w-100" loading="lazy"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contacts Settings Modal -->
                <div class="modal fade" id="site-contact-settings" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="contacts_settings_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Contact Settings</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="from-label mb-2 fw-bold">Address</label>
                                                    <input type="text" name="address" id="address_input" class="form-control shadow-none w-100" required/>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="from-label mb-2 fw-bold">Google Map Link</label>
                                                    <input type="text" name="gmap" id="gmap_input" class="form-control shadow-none w-100" required/>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="from-label mb-2 fw-bold">Phone Numbers <span style="font-size: xx-small;">(with country code)</span></label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                        <input type="text" name="phn_1" id="phn_1_input" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                        <input type="text" name="phn_2" id="phn_2_input" class="form-control shadow-none">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="from-label mb-2 fw-bold">Email</label>
                                                    <input type="text" name="email" id="email_input" class="form-control shadow-none w-100" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="from-label mb-2 fw-bold">Social Links</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-facebook me-1"></i></span>
                                                        <input type="text" name="fb" id="fb_input" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-twitter me-1"></i></span>
                                                        <input type="text" name="tw" id="tw_input" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-youtube me-1"></i></span>
                                                        <input type="text" name="yt" id="yt_input" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="from-label mb-2 fw-bold">iFrame Src</label>
                                                        <input type="text" name="iframe" id="iframe_input" class="form-control shadow-none w-100" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary btn-fw" onclick="contacts_input(contacts_data)" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-inverse-warning btn-fw">SAVE CHANGES</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

    <?php require('../include/scripts.php') ?>
    <?php require('include/commonScripts.php') ?>
    
    <script>
        let general_data, maintenance_title_val, contacts_data;

        let siteTitle_input = document.getElementById('siteTitle_input');
        let siteAbout_input = document.getElementById('siteAbout_input');
        let general_settings_form = document.getElementById('general_settings_form');
        let contacts_settings_form = document.getElementById('contacts_settings_form');

        general_settings_form.addEventListener('submit', function(e){
                e.preventDefault();
                upd_general(siteTitle_input.value, siteAbout_input.value);
            })

        function get_general(){
            let siteTitle = document.getElementById('siteTitle');
            let siteAbout = document.getElementById('siteAbout');
    
            let maintenance_toggle = document.getElementById('maintenanceToggle');
            let maintenance_title = document.getElementById('maintenanceTitle');

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function(){
                general_data = JSON.parse(this.responseText);
                
                siteTitle.innerText = general_data.siteTitle;
                siteAbout.innerText = general_data.siteAbout;

                siteTitle_input.value = general_data.siteTitle;
                siteAbout_input.value = general_data.siteAbout;

                if(general_data.isMaintenance > 0){
                    maintenance_toggle.checked = true;
                    maintenance_toggle.value = 1;
                    maintenance_title_val = 'Website Under Maintenance';
                    maintenanceTitle.innerText = maintenance_title_val;
                } else {
                    maintenance_toggle.checked = false;
                    maintenance_toggle.value = 0;
                    maintenance_title_val = 'Website is Active';
                    maintenanceTitle.innerText = maintenance_title_val;
                }
            }

            xhr.send('getData');
        }

        function upd_maintenance(value){
            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function(){
                if(this.responseText > 0 && general_data.isMaintenance < 1){
                    alert('success','Under maintenance mode activated!');
                } else {
                    alert('success','The website has been live now!');
                }
                get_general();
            }

            xhr.send('upd_maintenance='+value);
        }

        function upd_general(siteTitle_val, siteAbout_val){
            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            var generalSettingsModal = document.getElementById('site-general-settings');
            var modal = bootstrap.Modal.getInstance(generalSettingsModal);
            modal.hide();
            
            xhr.onload = function(){
                if(this.responseText > 0){
                    alert('success','Changes saved!');
                    get_general();
                } else {
                    alert('error','No changes made!');
                }
            }

            xhr.send('siteTitle='+siteTitle_val+'&siteAbout='+siteAbout_val+'&upd_general');
            
        }

        function get_contacts(){

            let contacts_data_id = ['address','gmap','phn-1','phn-2','email','facebook_link','twitter_link','youtube_link'];
            let iFrame = document.getElementById('iframe');

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function(){
                contacts_data = JSON.parse(this.responseText);
                contacts_data = Object.values(contacts_data);

                for(i=0; i < contacts_data_id.length; i++){
                    document.getElementById(contacts_data_id[i]).innerText = contacts_data[i+4];
                }

                iFrame.src = contacts_data[12];
                contacts_input(contacts_data);
            }

            xhr.send('getContacts');
        }

        function contacts_input(data){
            let contacts_input_id = ['address_input','gmap_input','phn_1_input','phn_2_input','email_input','fb_input','tw_input','yt_input', 'iframe_input'];
            
            for(i=0; i < contacts_input_id.length; i++){
                document.getElementById(contacts_input_id[i]).value = data[i+4];
            }
        }

        contacts_settings_form.addEventListener('submit',function(e){
            e.preventDefault();
            upd_contacts();
        })

        function upd_contacts(){
            let index = ['address','gmap','phn_1','phn_2','email','fb','tw','yt', 'iframe'];
            let contacts_input_id = ['address_input','gmap_input','phn_1_input','phn_2_input','email_input','fb_input','tw_input','yt_input', 'iframe_input'];
            
            let data_str = "";

            for(i = 0; i < index.length; i++){
                data_str += index[i] + "=" + document.getElementById(contacts_input_id[i]).value + '&';
            }
            data_str += "upd_contacts";

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                var contactsSettingsModal = document.getElementById('site-contact-settings');
                var modal = bootstrap.Modal.getInstance(contactsSettingsModal);
                modal.hide();

                if(this.responseText > 0){
                    alert('success','Changes saved!');
                    get_contacts();
                } else {
                    alert('error','No changes made!');
                }
            }

            xhr.send(data_str);
        }

        window.onload = function(){
            get_general();
            get_contacts();
        }
    </script>
</body>
</html>