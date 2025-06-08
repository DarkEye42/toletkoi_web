<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Emoji CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/twemoji@latest/2.7.0/2/twemoji.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Emoji JS -->
    <script src="https://cdn.jsdelivr.net/npm/twemoji@latest/2.7.0/2/twemoji.js" crossorigin="anonymous"></script>
    <?php
        session_start();
        $receiverID = isset($_GET['chatID']) ? $_GET['chatID'] : $_SESSION['id'];
    ?>
    <script>
        $(document).ready(function() {
            var receiverID = '<?=$receiverID?>'; // Receiver ID will be set dynamically

            // Load chat history
            function loadChatHistory() {
                $.ajax({
                    url: "load_chats.php",
                    method: "POST",
                    data: {
                        receiver_id: receiverID
                    },
                    success: function(response) {
                        // Display chat history
                        $("#chatHistory").html(response);
                    }
                });
            }

            // Send message
            $("#messageForm").submit(function(event) {
                event.preventDefault();

                var message = $("#message").val();

                if (message.trim() !== '') {
                    $.ajax({
                        url: "send_message.php",
                        method: "POST",
                        data: {
                            receiver_id: receiverID,
                            message: message
                        },
                        success: function(response) {
                            // Clear the input field
                            $("#message").val('');
                            alert(response);

                            // Load updated chat history
                            loadChatHistory();
                        }
                    });
                }
            });

            // Load chat history initially
            loadChatHistory();

            // Emoji selection
            $("#message").emojiPicker({
                width: '300px',
                height: '200px',
                button: false
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Left-side section for other chats -->
                <h3>Other Chats</h3>
                <!-- Display other chats list here -->
            </div>
            <div class="col-md-8">
                <!-- Chat history -->
                <h3>Chat History</h3>
                <div id="chatHistory"></div>
                <br>
                <!-- Message input form -->
                <form id="messageForm" method="post" action="">
                    <textarea id="message" name="message" class="form-control" rows="3"></textarea>
                    <br>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>