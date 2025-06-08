<script>
    function alert(type, message){
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let alert_name = (type == 'success') ? 'Success: ' : 'Error: ';
        let element = document.createElement('div');
        element.innerHTML =`
            <div class="alert ${bs_class} alert-dismissible fade show custom-alert shadow" role="alert">
                <strong>${alert_name}</strong> ${message}
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        document.body.append(element);
    }

    function setActive() {
        let navbar = document.getElementById('side-bar');
        let a_tags = navbar.getElementsByTagName('a');
        let li_tags = navbar.getElementsByTagName('li');

        for (i = 0; i < a_tags.length; i++) {
            let file = a_tags[i].href.split('/').pop();
            let file_name = file.split('.')[0];

            if (file_name === '') {
                // Skip if the href is '#'
                continue;
            }

            if (document.location.href.indexOf(file_name) >= 0) {
                li_tags[i].classList.add('active');
                console.log(file_name);
            }
        }
    }

    setActive();

    (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
                }, false)
            })
        })()

        $(document).ready(function(){
        // Check if email is available
        $('#email').blur(function(){
            var email = $(this).val();
            $.ajax({
                url: 'include/check_email.php',
                method: 'POST',
                data: {email: email},
                success: function(data){
                    $('#email-result').html(data);
                }
            });
        });
        
        // Check if phone number is available
        $('#phone').blur(function(){
            var phone = $(this).val();
            $.ajax({
                url: 'include/check_phone.php',
                method: 'POST',
                data: {phone: phone},
                success: function(data){
                    $('#phone-result').html(data);
                }
            });
        });
        
        // Check password strength
        $('#password').keyup(function(){
            var password = $(this).val();
            $.ajax({
                url: 'include/check_password.php',
                method: 'POST',
                data: {password: password},
                success: function(data){
                    $('#password-strength').html(data);
                }
            });
        });
    });

    $(document).ready(function() {
    // Handle thumbnail click event
    $('.thumbnail').on('click', function() {
        var imageUrl = $(this).attr('src');

        // Update the preview image source
        $('#previewImage').attr('src', imageUrl);
    });

    // Handle preview image hover event
    $('#previewContainer').on('mousemove', function(e) {
        var $zoomContainer = $('#zoomContainer');
        var $previewImage = $('#previewImage');

        var mouseX = e.pageX - $(this).offset().left;
        var mouseY = e.pageY - $(this).offset().top;

        var zoomX = (mouseX / $zoomContainer.width()) * 100;
        var zoomY = (mouseY / $zoomContainer.height()) * 100;

        // Apply zoom effect to the preview image
        $previewImage.css('transform-origin', zoomX + '% ' + zoomY + '%');
        $previewImage.addClass('zoomed');
    }).on('mouseleave', function() {
        var $previewImage = $('#previewImage');

        // Remove zoom effect from the preview image
        $previewImage.css('transform-origin', 'center center');
        $previewImage.removeClass('zoomed');
    });
});

    var incrementBtn = document.getElementsByClassName('increment');
    var decrementBtn = document.getElementsByClassName('decrement');
    // console.log(incrementBtn);
    // console.log(decrementBtn);

    // Increment
    for (var i = 0; i < incrementBtn.length; i++) {
        var button = incrementBtn[i];
        button.addEventListener('click', function(event) {

            var buttonClicked = event.target;
            //console.log(incrementBtn);
            var input = buttonClicked.parentElement.children[1];
            //console.log(input);
            var inputValue = input.value;
            //console.log(inputValue);
            var newValue = parseInt(inputValue) + 1;
            //console.log(newValue);
            input.value = newValue;
        });
    }

    // Decrement
    for (var i = 0; i < decrementBtn.length; i++) {
        var button = decrementBtn[i];
        button.addEventListener('click', function(event) {

            var buttonClicked = event.target;
            //console.log(decrementBtn);
            var input = buttonClicked.parentElement.children[1];
            //console.log(input);
            var inputValue = input.value;
            //console.log(inputValue);
            var newValue = parseInt(inputValue) - 1;
            //console.log(newValue);
            if(newValue >= 1){
                input.value = newValue;
            } else {
                input.value = 1;
                alert("QTY can't be less than 1");
            }
        });
    }

    
    $('#reg-mode-select').on('change', function() {
        var checkbox = $(this);
        var checkboxLabel = $('#reg-mode');

        if (checkbox.is(':checked')) {
        checkboxLabel.text('(House Owner)');
        checkbox.val('1');
        } else {
        checkboxLabel.text('(Renter)');
        checkbox.val('0');
        }
    });
</script>