<div class="col-12 overflow-hidden">  
    <div class="container-fluid bg-white mt-5">
        <div class="row">
            <div class="col-lg-4 p-4">
                <!-- <h3 class="h-font fw-bold fs-3 mb-2">Rental Orb</h3> -->
                <img src="files/logo.svg" alt="Logo" srcset="files/logo.svg" style="width: 15rem;" />
                <p>
                Discover your dream home in Bangladesh with RentalOrb, the premier home rental service. Browse quality properties, enjoy transparent renting, and experience exceptional customer support. Simplifying your search, one home at a time. #RentalOrb #Bangladesh
                </p>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Links</h5>
                <a href="index.php" class="d-inline-block mb-2 text-decoration-none">Home</a> <br>
                <a href="shop.php" class="d-inline-block mb-2 text-decoration-none">Shop Products</a> <br>
                <a href="rentals.php" class="d-inline-block mb-2 text-decoration-none">Rentals Ads</a> <br>
                <a href="contact.php" class="d-inline-block mb-2 text-decoration-none">Contact Us</a> <br>
                <a href="about.php" class="d-inline-block mb-2 text-decoration-none">About Us</a>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Follow Us</h5>
                <a href="<?php echo $contact_result['tw']; ?>" class="d-inline-block text-decoration-none mb-2">
                    <i class="bi bi-twitter me-1"></i> Twitter
                </a><br>
                <a href="<?php echo $contact_result['fb']; ?>" class="d-inline-block text-decoration-none mb-2">
                    <i class="bi bi-facebook me-1"></i> Facebook
                </a><br>
                <a href="<?php echo $contact_result['yt']; ?>" class="d-inline-block text-decoration-none">
                    <i class="bi bi-youtube me-1"></i> Youtube
                </a>
            </div>
        </div>
    </div>
    
    <h6 class="text-center bg-secondary text-white p-3 m-0">Designed &amp; Developed by DarkEye IT Ltd.</h6>
    <!-- Scroll to top button -->
    <button id="scroll-to-top" title="Go to top"><i class="bi bi-arrow-up fw-bolder"></i> Go to top</button>
</div>

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