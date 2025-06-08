
$(document).ready(function() {
    $('#division').change(function() {
        var id = $(this).val();
        $.ajax({

            url: "include/loc_getter_setter",
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
            url: "include/loc_getter_setter",
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
$(document).ready(function() {
    $('#area').change(function() {
        var id = $(this).val();
        $.ajax({
            url: "include/loc_getter_setter",
            method: "POST",
            data: {
                thanaId: id
            },
            dataType: "text",
            success: function(data) {
                $('#thanaHtml').html(data);
                generateURL(area);
            }
        });
    });

    function generateURL(action) {
        var selectedItem = $('input[name="propertyType"]:checked').val();
        var inputValue = $('#thana').val();
        
        if (action == category && inputValue == null){
            var url = '/category/' + selectedItem;
            var modifiedValue = url.replace(/\s/g, '-'); // Replace white spaces with underscores
            $('#searchBtn').attr('href', 'explore' + modifiedValue);
            console.log('explore' + modifiedValue); // Print the generated URL
        } else if(action == area && inputValue != null){
            var url = '/area/' + inputValue + '/category/' + selectedItem;
            var modifiedValue = url.replace(/\s/g, '-'); // Replace white spaces with underscores
            $('#searchBtn').attr('href', 'explore' + modifiedValue);
            console.log('explore' + modifiedValue); // Print the generated URL
        } else {
            var url = '/area/' + inputValue + '/category/' + selectedItem;
            var modifiedValue = url.replace(/\s/g, '-'); // Replace white spaces with underscores
            $('#searchBtn').attr('href', 'explore' + modifiedValue);
            console.log('explore' + modifiedValue); // Print the generated URL
        }

        // You can perform additional actions with the generated URL here
    }

    $('input[type="radio"]').change(function() {
        generateURL(category);
    });

    $(onload).ready(function() {
        generateURL(category);
    });
});