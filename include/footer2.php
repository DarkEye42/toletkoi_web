<!-- <div class="container-fluid bg-white mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 p-4">
                <h3 class="h-font fw-bold fs-3 mb-2">Rental Orb</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Tempora impedit sunt fugiat, quisquam distinctio itaque.
                    Est commodi, accusamus voluptatem modi maiores expedita
                    rem dignissimos praesentium magnam quia. Alias, ipsam velit!
                </p>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Links</h5>
                <a href="index.php" class="d-inline-block mb-2 gray-900 text-decoration-none">Home</a> <br>
                <a href="shop.php" class="d-inline-block mb-2 gray-900 text-decoration-none">Shop Products</a> <br>
                <a href="rentals.php" class="d-inline-block mb-2 gray-900 text-decoration-none">Rentals Ads</a> <br>
                <a href="contact.php" class="d-inline-block mb-2 gray-900 text-decoration-none">Contact Us</a> <br>
                <a href="about.php" class="d-inline-block mb-2 gray-900 text-decoration-none">About Us</a>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Follow Us</h5>
                <a href="<?php //echo $contact_result['tw']; ?>" class="d-inline-block gray-900 text-decoration-none mb-2">
                    <i class="bi bi-twitter me-1"></i> Twitter
                </a><br>
                <a href="<?php //echo $contact_result['fb']; ?>" class="d-inline-block gray-900 text-decoration-none mb-2">
                    <i class="bi bi-facebook me-1"></i> Facebook
                </a><br>
                <a href="<?php //echo $contact_result['yt']; ?>" class="d-inline-block gray-900 text-decoration-none">
                    <i class="bi bi-youtube me-1"></i> Youtube
                </a>
            </div>
        </div>
    </div>
</div> -->

<!-- <h6 class="text-center bg-secondary text-white p-3 m-0 w-100">Designed &amp; Developed by DarkEye IT Ltd.</h6> -->

<amp-auto-ads type="adsense"
        data-ad-client="ca-pub-7549719830059811">
</amp-auto-ads>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
<section class="deneb_cta">
	<div class="container">
		<div class="cta_wrapper">
			<div class="row align-items-center">
				<div class="col-lg-7">
					<div class="cta_content">
						<h3>Have Any Trouble &amp; Need Help ?</h3>
						<p>Finding a home in Bangladesh made easy with RentalOrb. Browse, rent, and enjoy exceptional customer support. Simplify your search with us! #RentalOrb</p>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="button_box">
						<a href="contact.php" class="btn btn-warning">Contact With Us</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<footer class="deneb_footer">
	<div class="widget_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 col-12">
					<div class="widget widegt_about">
						<div class="widget_title">
							<img src="files/logo.svg" alt="Logo" srcset="files/logo.svg" style="width: 20rem;" />
						</div>
						<p>Discover your dream home in Bangladesh with RentalOrb, the premier home rental service. Browse quality properties, enjoy transparent renting, and experience exceptional customer support. Simplifying your search, one home at a time. #RentalOrb #Bangladesh</p>
						<ul class="social">
							<li><a href="<?php echo $contact_result['fb']; ?>"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="<?php echo $contact_result['tw']; ?>"><i class="fab fa-twitter"></i></a></li>
							<li><a href="<?php echo $contact_result['yt']; ?>"><i class="fab fa-youtube"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12">
					<div class="widget widget_link">
						<div class="widget_title">
							<h4>Links</h4>
						</div>
						<ul>
							<li><a href="index.php">Home Page</a></li>
							<li><a href="shop.php">Shop Products</a></li>
							<li><a href="rentals.php">Rentals Ads</a></li>
							<li><a href="contact.php">Contact Us</a></li>
                            <li><a href="about.php">About Us</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12">
					<div class="widget widget_contact">
						<div class="widget_title">
							<h4>Contact Us</h4>
						</div>
						<div class="contact_info">
							<div class="single_info">
								<div class="icon">
									<i class="bi bi-telephone-fill fw-bold fs-5"></i>
								</div>
								<div class="info">
									<p><a href="tel:+<?php echo $contact_result['phn1']; ?>">+<?php echo $contact_result['phn1']; ?></a></p>
								</div>
							</div>
							<div class="single_info">
								<div class="icon">
									<i class="bi bi-envelope-at-fill fw-bold fs-5"></i>
								</div>
								<div class="info">
									<p><a href="mailto:<?php echo $contact_result['email']; ?>"><?php echo $contact_result['email']; ?></a></p>
								</div>
							</div>
							<div class="single_info">
								<div class="icon">
									<i class="bi bi-geo-alt-fill fw-bold fs-5"></i>
								</div>
								<div class="info">
									<p><?php echo $contact_result['address']; ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright_area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="copyright_text">
						<p>Copyright &copy; 2020 All rights reserved. Designed &amp; Developed by DarkEye IT Ltd.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Scroll to top button -->
    <button id="scroll-to-top" title="Go to top">↑ Go to top</button>
</footer>

<?php require('include/scripts.php')?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js" integrity="sha512-jEnuDt6jfecCjthQAJ+ed0MTVA++5ZKmlUcmDGBv2vUI/REn6FuIdixLNnQT+vKusE2hhTk2is3cFvv5wA+Sgg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function changeId(id){
        let index_id = document.getElementById(id);
        if(index_id.checked){
            index_id.value = 'Yes';
            console.log(id+': '+index_id.value);
        } else {
            index_id.value = 'No';
            console.log(id+': '+index_id.value);
        }
    }

    // Load the Lottie animation file
    const animationContainer = document.getElementById('preloader-animation');
    const animationPath = 'files/map_marker.json'; // Replace with the path to your Lottie animation file

    const animation = lottie.loadAnimation({
    container: animationContainer,
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: animationPath
    });

    // Hide the preloader when the animation completes
	$(window).on('load', function() {
		$(".preloader").delay(600).fadeOut();
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
	document.getElementById('burger-btn').addEventListener('click', scrollToTop);
</script>