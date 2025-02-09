<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "Praneetha@1";
$dbname = "artgallery";


if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}


if (!isset($_GET['art_id'])) {
    die("Art ID not specified.");
}

$art_id = $_GET['art_id'];
$artist_username = $_SESSION['username'];


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "DELETE FROM art_uploads WHERE product_id = ? AND username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $art_id, $artist_username);


if ($stmt->execute()) {
    header("Location: manageArts.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
