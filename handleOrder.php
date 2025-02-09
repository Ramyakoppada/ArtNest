<?php
session_start();

if (!isset($_SESSION['username'])) {
    die("You are not logged in.");
}

$servername = "localhost";
$username = "root";
$password = "Harshi#2005";
$dbname = "artgallery";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];

    if ($action == "accept") {
        $stmt = $conn->prepare("UPDATE art_requests SET status = 'accepted' WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
    } elseif ($action == "deny") {
        $stmt = $conn->prepare("UPDATE art_requests SET status = 'denied' WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
    }

    if ($stmt->execute()) {
        echo "<script>
                alert('Order has been " . ($action == 'accept' ? 'accepted' : 'denied') . ".');
                window.location.href = 'productReqDisplay.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
