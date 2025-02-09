<?php
$servername = "localhost";
$username = "root";
$password = "Praneetha@1";
$dbname = "artgallery";
include 'emailTesting.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['username'])) {
    $username = $conn->real_escape_string($_GET['username']);
    $sql = "SELECT email, phone FROM artist WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $password = $row['phone'];
        $sql = "DELETE FROM artist WHERE username='$username'";
        if ($conn->query($sql) === TRUE) {
            $message = "Artist deleted successfully.";
            sendEmail($username, $email, $password, 'delete');
        } else {
            $message = "Error deleting artist: " . $conn->error;
        }
    } else {
        $message = "Artist not found.";
    }

    header("Location: manageArtist.php?message=" . urlencode($message));
    exit();
} else {
    header("Location: manageArtist.php");
    exit();
}

$conn->close();
?>
