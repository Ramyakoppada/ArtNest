<?php
$servername = "localhost";
$username = "root";
$password = "Harshi#2005";
$dbname = "artgallery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['username'])) {
    $username = $conn->real_escape_string($_GET['username']);

    // Delete artist from the database
    $sql = "DELETE FROM artist WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        $message = "Artist deleted successfully.";
    } else {
        $message = "Error deleting artist: " . $conn->error;
    }

    // Redirect back to the main page with the message
    header("Location: manageArtist.php?message=" . urlencode($message));
    exit();
} else {
    header("Location: manageArtist.php");
    exit();
}

$conn->close();
?>
