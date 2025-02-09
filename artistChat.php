<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "Praneetha@1";
$dbname = "artgallery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the artist's username from session
$artist_username = $_SESSION['username'];

// Fetch all users who have sent messages to the artist
$sql = "SELECT DISTINCT sender_username FROM chat_messages WHERE receiver_username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $artist_username);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Artist View Chats</title>
    <style>
        body {
            background: url('background.jpeg') no-repeat;
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(10px);
        }
        .heading {
            text-align: center;
            margin-bottom: 20px;
            color: black;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
        }
        .card-title {
            margin-bottom: 10px;
        }
        .card-actions {
            margin-top: 15px;
        }
        .chat-window {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            max-height: 500px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            z-index: 1000;
            border-radius: 10px;
        }
        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .chat-messages {
            padding: 10px;
            max-height: 350px;
            overflow-y: auto;
        }
        .chat-input {
            padding: 10px;
            border-top: 1px solid #ccc;
        }
        .chat-input input[type="text"] {
            width: calc(100% - 60px);
            display: inline-block;
        }
        .chat-input button {
            width: 50px;
            display: inline-block;
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message strong {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="heading">
            <h1>Chats with Users</h1>
        </div>
        <div class="card-container">
            <?php
            if (!empty($users)) {
                foreach ($users as $user) {
                    echo "<div class='card'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($user['sender_username']) . "</h5>";
                    echo "<button class='btn btn-primary' onclick='openChatWindow(\"" . htmlspecialchars($user['sender_username']) . "\")'><i class='fa fa-comments'></i> View Chat</button>";
                    echo "</div>";
                }
            } else {
                echo "<div class='text-center'>No chats found</div>";
            }
            ?>
        </div>
    </div>

    <div class="chat-window" id="chat-window">
        <div class="chat-header">
            <span id="chat-header-username"></span>
            <button type="button" class="close" onclick="closeChatWindow()">&times;</button>
        </div>
        <div class="chat-messages" id="chat-messages"></div>
        <div class="chat-input">
            <form id="chat-form" onsubmit="sendMessage(event)">
                <input type="hidden" id="chat-sender" value="<?php echo $artist_username; ?>">
                <input type="hidden" id="chat-receiver">
                <input type="text" id="chat-message" class="form-control" placeholder="Type a message...">
                <button type="submit" class="btn btn-primary mt-2">Send</button>
            </form>
        </div>
    </div>

    <script>
        function openChatWindow(username) {
            document.getElementById('chat-receiver').value = username;
            document.getElementById('chat-header-username').innerText = 'Chat with ' + username;
            document.getElementById('chat-window').style.display = 'block';
            fetchMessages();
        }

        function closeChatWindow() {
            document.getElementById('chat-window').style.display = 'none';
            document.getElementById('chat-messages').innerHTML = '';
        }

        function fetchMessages() {
            const sender = document.getElementById('chat-sender').value;
            const receiver = document.getElementById('chat-receiver').value;
            fetch(`chat.php?sender=${sender}&receiver=${receiver}`)
                .then(response => response.json())
                .then(messages => {
                    const chatMessages = document.getElementById('chat-messages');
                    chatMessages.innerHTML = '';
                    messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        messageElement.classList.add('chat-message');
                        messageElement.innerHTML = `<strong>${message.sender_username}:</strong> ${message.message}`;
                        chatMessages.appendChild(messageElement);
                    });
                });
        }

        function sendMessage(event) {
            event.preventDefault();
            const sender = document.getElementById('chat-sender').value;
            const receiver = document.getElementById('chat-receiver').value;
            const message = document.getElementById('chat-message').value;
            fetch('chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `sender=${sender}&receiver=${receiver}&message=${message}`
            }).then(() => {
                document.getElementById('chat-message').value = '';
                fetchMessages();
            });
        }

        setInterval(fetchMessages, 5000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
