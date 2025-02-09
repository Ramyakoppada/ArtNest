<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Praneetha@1";
$dbname = "artgallery";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'artist') {
    die("Unauthorized access.");
}
if (isset($_GET['action']) && isset($_GET['username'])) {
    $action = $_GET['action'];
    $username = $_GET['username'];

    if ($action === 'accept') {

        echo "<script>
                alert('Request accepted.');
                window.location.href = 'viewRequests.php';
              </script>";
    } elseif ($action === 'deny') {
        $stmt = $conn->prepare("DELETE FROM art_requests WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            echo "<script>
                    alert('Request denied.');
                    window.location.href = 'viewRequests.php';
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
