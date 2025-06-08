<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rental Orb - Owner Dashboard</title>

  <link rel="stylesheet" href="assets/css/main/app.css" />
  <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon" />
  <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png" />
  <link rel="stylesheet" href="assets/extensions/@fortawesome/fontawesome-free/css/all.min.css" />
  <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="assets/css/shared/iconly.css" />
  <?php require('include/commonLinks2.php') ?>
</head>

<body>
  <!-- Mid Body Section Start -->
  <div class="container-fluid overflow-hidden">
    <div class="row">
      <?php //require('include/sidebar.php') 
      ?>
      <div id="main" class="layout-horizontal">
      <?php require('include/header2.php') ?>
        <div class="container">
          <div class="row">
            <div class="page-heading">
              <h3>Owner Dashboard</h3>
              <div class="row mb-0">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-body py-4 px-5">
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                          <img src="files/admin/about/dev_img.jpg" alt="Face 1" />
                        </div>
                        <div class="ms-3 name">
                          <h5 class="font-bold">Nazmul Islam</h5>
                          <h6 class="text-muted mb-0">
                            <a href="#">Public Profile</a>
                          </h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="card">
                    <div class="card-body py-4 px-3">
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                          <div class="stats-icon purple mb-2" style="height: 52px; width: 52px">
                            <i class="iconly-boldWallet"></i>
                          </div>
                        </div>
                        <div class="ms-3 name">
                          <h5 class="font-bold">Balance</h5>
                          <h6 class="text-muted mb-0">৳100.00</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="card">
                    <div class="card-body py-4 px-3">
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                          <div class="stats-icon blue mb-2" style="height: 52px; width: 52px">
                            <i class="iconly-boldInfo-Square"></i>
                          </div>
                        </div>
                        <div class="ms-3 name">
                          <div class="row">
                            <h5 class="font-bold col-md-9">
                              Your Info
                              <span class="text-muted" style="font-size: small">(Visible to everyone)</span>
                            </h5>
                            <a href="#" class="text-info col-md-3 mb-2 fw-bold">
                              <i class="iconly-boldEdit"></i>
                              Update Info
                            </a>
                          </div>

                          <h6 class="mb-0 d-flex">
                            Nid: <span class="text-danger ps-2">Not Verified</span>
                            <span class="text-muted px-2"> | </span>
                            <i class="iconly-boldMessage text-success fs-5"></i> <span class="text-success">Verified</span>
                            <span class="text-muted px-2"> | </span>
                            <i class="iconly-boldLocation text-info fs-5"></i>
                            <span class="text-muted">Paler Para, Gazipur Sadar, Gazipur - 1702</span>
                          </h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="page-content">
              <h3>Ads & Renters Analytics</h3>
              <section class="row">
                <div class="col-12 col-lg-9">
                  <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                      <div class="card">
                        <div class="card-body px-4 py-4-5">
                          <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                              <div class="stats-icon purple mb-2">
                                <i class="iconly-boldShow"></i>
                              </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                              <h6 class="text-muted font-semibold">Ads Views</h6>
                              <h6 class="font-extrabold mb-0">112k</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                      <div class="card">
                        <div class="card-body px-4 py-4-5">
                          <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                              <div class="stats-icon red mb-2">
                                <i class="iconly-boldHeart"></i>
                              </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                              <h6 class="text-muted font-semibold">Ads Liked</h6>
                              <h6 class="font-extrabold mb-0">183.000</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                      <div class="card">
                        <a class="card-body px-4 py-4-5" href="#requests">
                          <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                              <div class="stats-icon green mb-2">
                                <i class="iconly-boldAdd-User"></i>
                              </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                              <h6 class="text-muted font-semibold">Requests</h6>
                              <h6 class="font-extrabold mb-0">80.000</h6>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                      <div class="card">
                        <div class="card-body px-4 py-4-5">
                          <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                              <div class="stats-icon blue mb-2">
                                <i class="iconly-boldProfile"></i>
                              </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                              <h6 class="text-muted font-semibold">Renters</h6>
                              <h6 class="font-extrabold mb-0">112</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">All Rental Ads By You</h4>
                        </div>
                        <div class="card-content">
                          <!-- Table with no outer spacing -->
                          <div class="table-responsive">
                            <table class="table mb-0 table-lg">
                              <thead>
                                <tr>
                                  <th>NAME</th>
                                  <th>RATE</th>
                                  <th>SKILL</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="text-bold-500">Michael Right</td>
                                  <td>৳15/hr</td>
                                  <td class="text-bold-500">UI/UX</td>
                                </tr>
                                <tr>
                                  <td class="text-bold-500">Morgan Vanblum</td>
                                  <td>৳13/hr</td>
                                  <td class="text-bold-500">Graphic concepts</td>
                                </tr>
                                <tr>
                                  <td class="text-bold-500">Tiffani Blogz</td>
                                  <td>৳15/hr</td>
                                  <td class="text-bold-500">Animation</td>
                                </tr>
                                <tr>
                                  <td class="text-bold-500">Ashley Boul</td>
                                  <td>৳15/hr</td>
                                  <td class="text-bold-500">Animation</td>
                                </tr>
                                <tr>
                                  <td class="text-bold-500">Mikkey Mice</td>
                                  <td>৳15/hr</td>
                                  <td class="text-bold-500">Animation</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h4>Latest Comments</h4>
                        </div>
                        <div class="card-body pb-0">
                          <div class="table-responsive">
                            <table class="table table-hover table-lg mb-0">
                              <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Comment</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="col-3">
                                    <div class="d-flex align-items-center">
                                      <div class="avatar bg-warning me-3">
                                        <img src="assets/images/faces/5.jpg" alt="" srcset="">
                                        <span class="avatar-status bg-success"></span>
                                      </div>
                                      <p class="font-bold ms-3 mb-0">Cantik</p>
                                    </div>
                                  </td>
                                  <td class="col-auto">
                                    <p class="mb-0">
                                      Congratulations on your graduation!
                                    </p>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="col-3">
                                    <div class="d-flex align-items-center">
                                      <div class="avatar bg-warning me-3">
                                        <img src="assets/images/faces/2.jpg" alt="" srcset="">
                                        <span class="avatar-status bg-danger"></span>
                                      </div>
                                      <p class="font-bold ms-3 mb-0">Ganteng</p>
                                    </div>
                                  </td>
                                  <td class="col-auto">
                                    <p class="mb-0">
                                      Wow amazing design! Can you make another
                                      tutorial for this design?
                                    </p>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="col-3">
                                    <div class="d-flex align-items-center">
                                      <div class="avatar bg-warning me-3">
                                        <img src="assets/images/faces/1.jpg" alt="" srcset="">
                                        <span class="avatar-status bg-warning"></span>
                                      </div>
                                      <p class="font-bold ms-3 mb-0">Cantik</p>
                                    </div>
                                  </td>
                                  <td class="col-auto">
                                    <p class="mb-0">
                                      Congratulations on your graduation!
                                    </p>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h4>Profile Visit</h4>
                        </div>
                        <div class="card-body">
                          <div id="chart-profile-visit"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <!-- Basic Tables start -->
                      <section class="section" id="requests">
                        <div class="card">
                          <h5 class="card-header">Rental Requests</h5>
                          <div class="card-body">
                            <table class="table" id="table1">
                              <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>
                                  <th>City</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>Graiden</td>
                                  <td>vehicula.aliquet@semconsequat.co.uk</td>
                                  <td>076 4820 8838</td>
                                  <td>Offenburg</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Dale</td>
                                  <td>fringilla.euismod.enim@quam.ca</td>
                                  <td>0500 527693</td>
                                  <td>New Quay</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Nathaniel</td>
                                  <td>mi.Duis@diam.edu</td>
                                  <td>(012165) 76278</td>
                                  <td>Grumo Appula</td>
                                  <td>
                                    <span class="badge bg-danger">Inactive</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Darius</td>
                                  <td>velit@nec.com</td>
                                  <td>0309 690 7871</td>
                                  <td>Ways</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Oleg</td>
                                  <td>rhoncus.id@Aliquamauctorvelit.net</td>
                                  <td>0500 441046</td>
                                  <td>Rossignol</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Kermit</td>
                                  <td>diam.Sed.diam@anteVivamusnon.org</td>
                                  <td>(01653) 27844</td>
                                  <td>Patna</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Jermaine</td>
                                  <td>sodales@nuncsit.org</td>
                                  <td>0800 528324</td>
                                  <td>Mold</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Ferdinand</td>
                                  <td>
                                    gravida.molestie@tinciduntadipiscing.org
                                  </td>
                                  <td>(016977) 4107</td>
                                  <td>Marlborough</td>
                                  <td>
                                    <span class="badge bg-danger">Inactive</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Kuame</td>
                                  <td>Quisque.purus@mauris.org</td>
                                  <td>(0151) 561 8896</td>
                                  <td>Tresigallo</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Deacon</td>
                                  <td>Duis.a.mi@sociisnatoquepenatibus.com</td>
                                  <td>07740 599321</td>
                                  <td>Karapınar</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Channing</td>
                                  <td>
                                    tempor.bibendum.Donec@ornarelectusante.ca
                                  </td>
                                  <td>0845 46 49</td>
                                  <td>Warrnambool</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Aladdin</td>
                                  <td>sem.ut@pellentesqueafacilisis.ca</td>
                                  <td>0800 1111</td>
                                  <td>Bothey</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Cruz</td>
                                  <td>non@quisturpisvitae.ca</td>
                                  <td>07624 944915</td>
                                  <td>Shikarpur</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Keegan</td>
                                  <td>molestie.dapibus@condimentumDonecat.edu</td>
                                  <td>0800 200103</td>
                                  <td>Assen</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Ray</td>
                                  <td>placerat.eget@sagittislobortis.edu</td>
                                  <td>(0112) 896 6829</td>
                                  <td>Hofors</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Maxwell</td>
                                  <td>diam@dapibus.org</td>
                                  <td>0334 836 4028</td>
                                  <td>Thane</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Carter</td>
                                  <td>urna.justo.faucibus@orci.com</td>
                                  <td>07079 826350</td>
                                  <td>Biez</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Stone</td>
                                  <td>velit.Aliquam.nisl@sitametrisus.com</td>
                                  <td>0800 1111</td>
                                  <td>Olivar</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Berk</td>
                                  <td>
                                    fringilla.porttitor.vulputate@taciti.edu
                                  </td>
                                  <td>(0101) 043 2822</td>
                                  <td>Sanquhar</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Philip</td>
                                  <td>turpis@euenimEtiam.org</td>
                                  <td>0500 571108</td>
                                  <td>Okara</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Kibo</td>
                                  <td>feugiat@urnajustofaucibus.co.uk</td>
                                  <td>07624 682306</td>
                                  <td>La Cisterna</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Bruno</td>
                                  <td>
                                    elit.Etiam.laoreet@luctuslobortisClass.edu
                                  </td>
                                  <td>07624 869434</td>
                                  <td>Rocca d"Arce</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Leonard</td>
                                  <td>
                                    blandit.enim.consequat@mollislectuspede.net
                                  </td>
                                  <td>0800 1111</td>
                                  <td>Lobbes</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Hamilton</td>
                                  <td>mauris@diam.org</td>
                                  <td>0800 256 8788</td>
                                  <td>Sanzeno</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Harding</td>
                                  <td>Lorem.ipsum.dolor@etnetuset.com</td>
                                  <td>0800 1111</td>
                                  <td>Obaix</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Emmanuel</td>
                                  <td>eget.lacus.Mauris@feugiatSednec.org</td>
                                  <td>(016977) 8208</td>
                                  <td>Saint-Remy-Geest</td>
                                  <td>
                                    <span class="badge bg-success">Active</span>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </section>
                      <!-- Basic Tables end -->
                    </div>
                  </div>
                </div>
                <div class="col-12 col-lg-3">
                  <div class="card">
                    <div class="card-header">
                      <h4>Recent Messages</h4>
                    </div>
                    <div class="card-content pb-4">
                      <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                          <img src="assets/images/faces/4.jpg" />
                        </div>
                        <div class="name ms-4">
                          <h5 class="mb-1">Hank Schrader</h5>
                          <h6 class="text-muted mb-0">@johnducky</h6>
                        </div>
                      </div>
                      <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                          <img src="assets/images/faces/5.jpg" />
                        </div>
                        <div class="name ms-4">
                          <h5 class="mb-1">Dean Winchester</h5>
                          <h6 class="text-muted mb-0">@imdean</h6>
                        </div>
                      </div>
                      <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                          <img src="assets/images/faces/1.jpg" />
                        </div>
                        <div class="name ms-4">
                          <h5 class="mb-1">John Dodol</h5>
                          <h6 class="text-muted mb-0">@dodoljohn</h6>
                        </div>
                      </div>
                      <div class="px-4">
                        <button class="btn btn-block btn-xl btn-light-primary font-bold mt-3">
                          Start Conversation
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <h4>Visitors Profile</h4>
                    </div>
                    <div class="card-body">
                      <div id="chart-visitors-profile"></div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>


        <?php include('include/footer2.php'); ?>
      </div>
    </div>
  </div>
  <!-- Mid Body Section End -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/app.js"></script>
  <script src="assets/js/pages/horizontal-layout.js"></script>

  <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
  <script src="assets/js/pages/dashboard.js"></script>
  <script src="assets/extensions/jquery/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
  <script src="assets/js/pages/datatables.js"></script>
</body>

</html>