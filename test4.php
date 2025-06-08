<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter System</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <!-- Add your custom CSS -->
    <style>
        /* Customize counter section styles here */
        .counter-section {
            text-align: center;
            padding: 50px 0;
        }

        .counter {
            font-size: 36px;
            font-weight: bold;
            color: #007bff;
        }

        .counter-label {
            font-size: 18px;
            color: #555;
        }

        /* Scroll to top button style */
        #scroll-to-top {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            padding: 10px;
            border-radius: 50px;
        }

        /* Show the scroll to top button when user starts scrolling */
        #scroll-to-top.active {
            display: block;
        }

        .outer {
            display: flex;
            overflow-x: hidden;
            overflow-y: hidden;
        }

        .inner {
            flex: 0 0 25%;
            height: 100px;
            margin: 10px;
        }

        .paddle {
            position: absolute;
            top: 50px;
        }

        .lefty {
            left: 0;
        }

        .righty {
            right: 0;
        }

        /* Mail CSS */
        .mail-seccess {
            text-align: center;
            background: #fff;
            border-top: 1px solid #eee;
        }

        .mail-seccess .success-inner {
            display: inline-block;
        }

        .mail-seccess .success-inner h1 {
            font-size: 100px;
            text-shadow: 3px 5px 2px #3333;
            color: #006DFE;
            font-weight: 700;
        }

        .mail-seccess .success-inner h1 span {
            display: block;
            font-size: 25px;
            color: #333;
            font-weight: 600;
            text-shadow: none;
            margin-top: 20px;
        }

        .mail-seccess .success-inner p {
            padding: 20px 15px;
        }

        .mail-seccess .success-inner .btn {
            color: #fff;
        }

        /* Career List Css */

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }

        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.5rem 1.5rem;
        }

        .avatar-text {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background: #000;
            color: #fff;
            font-weight: 700;
        }

        .avatar {
            width: 3rem;
            height: 3rem;
        }

        .rounded-3 {
            border-radius: 0.5rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .me-4 {
            margin-right: 1.5rem !important;
        }
    </style>
</head>

<body>
    <!-- Counter Sections -->
    <div class="container">
        <div class="row">
            <div class="col-md-3 counter-section">
                <span class="counter" data-count="1020">0</span>
                <p class="counter-label">Clients</p>
            </div>
            <div class="col-md-3 counter-section">
                <span class="counter" data-count="850">0</span>
                <p class="counter-label">Projects</p>
            </div>
            <div class="col-md-3 counter-section">
                <span class="counter" data-count="530">0</span>
                <p class="counter-label">Freelancers</p>
            </div>
            <div class="col-md-3 counter-section">
                <span class="counter" data-count="890">0</span>
                <p class="counter-label">Success Stories</p>
            </div>
        </div>
    </div>

    <!-- Horizontal Product List -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card shadow border-0">
                    <button class="lefty paddle btn btn-light fw-bold fs-5 shadow" style="border-radius: 50%;" id="left-button"><i class="bi bi-caret-left-fill"></i></button>
                    <div class="card-body">
                        <div class="outer" id="content">
                            <div class="inner" style="background:red"></div>
                            <div class="inner" style="background:green"></div>
                            <div class="inner" style="background:blue"></div>
                            <div class="inner" style="background:yellow"></div>
                            <div class="inner" style="background:orange"></div>
                        </div>
                    </div>
                    <button class="righty paddle btn btn-light fw-bold fs-5 shadow" style="border-radius: 50%;" id="right-button"><i class="bi bi-caret-right-fill"></i></button>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">

                <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Version 1.3.8</span> - 4th Jun 2020</h5>
                <ul class="list-unstyled mt-3">
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>Latest Update Bootstrap v4.5</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>Latest Update jQuery v3.5.1</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>Latest Update Material Design Icons v5.3.45</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>New <b>RTL Version</b> (Only CSS Base)</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>New <b>Dark Version</b> (Only CSS Base)</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>New <b>Dark RTL Version</b> (Only CSS Base)</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>Added 6 Colors scheme</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>Fixed some responsive issues</li>
                </ul>

                <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Version 1.3.0</span> - 28t May 2020</h5>
                <ul class="list-unstyled mt-3">
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>Latest Update Material Design Icons v5.3.45</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>New <b>RTL Version</b> (Only CSS Base)</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>New <b>Dark Version</b> (Only CSS Base)</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>New <b>Dark RTL Version</b> (Only CSS Base)</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>Added 6 Colors scheme</li>
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>Fixed some responsive issues</li>
                </ul>

                <h5 class="mt-4"> <span class="p-2 bg-light shadow rounded text-success"> Version 1.0.0</span> - 4th March, 2020</h5>
                <ul class="list-unstyled mt-3">
                    <li class="text-muted ml-3"><i class="mdi mdi-circle-medium mr-2"></i>Initial Released</li>
                </ul>

                <div class="mt-4">
                    <a href="#" class="btn btn-primary">Purchase Now</a>
                </div>
            </div>
        </div>
    </div>

    <section class="mail-seccess section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <!-- Error Inner -->
                    <div class="success-inner">
                        <h1><i class="fa fa-envelope"></i><span>Your Mail Sent Successfully!</span></h1>
                        <p>Aenean eget sollicitudin lorem, et pretium felis. Nullam euismod diam libero, sed dapibus leo laoreet ut. Suspendisse potenti. Phasellus urna lacus</p>
                        <a href="#" class="btn btn-primary btn-lg">Go Home</a>
                    </div>
                    <!--/ End Error Inner -->
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="text-center mb-5">
            <h3>Jobs openning</h3>
            <p class="lead">Eros ante urna tortor aliquam nisl magnis quisque hac</p>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-column flex-lg-row">
                    <span class="avatar avatar-text rounded-3 me-4 mb-2">FD</span>
                    <div class="row flex-fill">
                        <div class="col-sm-5">
                            <h4 class="h5">Junior Frontend Developer</h4>
                            <span class="badge bg-secondary">WORLDWIDE</span> <span class="badge bg-success">$60K - $100K</span>
                        </div>
                        <div class="col-sm-4 py-2">
                            <span class="badge bg-secondary">REACT</span>
                            <span class="badge bg-secondary">NODE</span>
                            <span class="badge bg-secondary">TYPESCRIPT</span>
                            <span class="badge bg-secondary">JUNIOR</span>
                        </div>
                        <div class="col-sm-3 text-lg-end">
                            <a href="#" class="btn btn-primary stretched-link">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-column flex-lg-row">
                    <span class="avatar avatar-text rounded-3 me-4 bg-warning mb-2">BE</span>
                    <div class="row flex-fill">
                        <div class="col-sm-5">
                            <h4 class="h5">Senior Backend Engineer</h4>
                            <span class="badge bg-secondary">US</span> <span class="badge bg-success">$90K - $180K</span>
                        </div>
                        <div class="col-sm-4 py-2">
                            <span class="badge bg-secondary">GOLANG</span>
                            <span class="badge bg-secondary">SENIOR</span>
                            <span class="badge bg-secondary">ENGINEER</span>
                            <span class="badge bg-secondary">BACKEND</span>
                        </div>
                        <div class="col-sm-3 text-lg-end">
                            <a href="#" class="btn btn-primary stretched-link">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-column flex-lg-row">
                    <span class="avatar avatar-text rounded-3 me-4 bg-info mb-2">PM</span>
                    <div class="row flex-fill">
                        <div class="col-sm-5">
                            <h4 class="h5">Director of Product Marketing</h4>
                            <span class="badge bg-secondary">WORLDWIDE</span> <span class="badge bg-success">$150K - $210K</span>
                        </div>
                        <div class="col-sm-4 py-2">
                            <span class="badge bg-secondary">PRODUCT MARKETING</span>
                            <span class="badge bg-secondary">MARKETING</span>
                            <span class="badge bg-secondary">EXECUTIVE</span>
                            <span class="badge bg-secondary">ECOMMERCE</span>
                        </div>
                        <div class="col-sm-3 text-lg-end">
                            <a href="#" class="btn btn-primary stretched-link">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 1500px;">
        <p>Scroll down to see the scroll-to-top button in action.</p>
    </div>

    <!-- Scroll to top button -->
    <button id="scroll-to-top" title="Go to top">↑ Go to top</button>

    <!-- Add jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Function to animate the counter numbers
        function animateCounter() {
            $('.counter').each(function() {
                var target = parseInt($(this).attr('data-count'));
                var start = 0;
                var duration = 2000; // Change this value to adjust animation speed (in milliseconds)
                var step = Math.ceil(target / (duration / 50)); // Update counter in smaller steps for smoother animation

                var counterInterval = setInterval(function() {
                    start += step;
                    if (start >= target) {
                        start = target;
                        clearInterval(counterInterval);
                    }
                    $(this).text(start);
                }.bind(this), 50);
            });
        }

        // Call the animateCounter function when the page is fully loaded
        $(document).ready(function() {
            animateCounter();
        });

        // Function to show/hide the scroll to top button
        function toggleScrollToTopButton() {
            const scrollToTopButton = document.getElementById('scroll-to-top');
            if (window.scrollY >= 500) {
                scrollToTopButton.classList.add('active');
            } else {
                scrollToTopButton.classList.remove('active');
            }
        }

        // Function to scroll to the top when the button is clicked
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Attach event listeners
        window.addEventListener('scroll', toggleScrollToTopButton);
        document.getElementById('scroll-to-top').addEventListener('click', scrollToTop);

        $('#right-button').click(function() {
            event.preventDefault();
            $('#content').animate({
                scrollLeft: "+=200px"
            }, "slow");
        });

        $('#left-button').click(function() {
            event.preventDefault();
            $('#content').animate({
                scrollLeft: "-=200px"
            }, "slow");
        });
    </script>
</body>

</html>