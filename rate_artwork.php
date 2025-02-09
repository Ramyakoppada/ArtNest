<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist_username = $_POST['artist_username'];
    $rating = $_POST['rating'];

    
    $conn = openConnection();

   
    $sql = "INSERT INTO artist_rating (artist_username, rating) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $artist_username, $rating);
    if (!$stmt->execute()) {
        die("Failed to insert rating: " . $stmt->error);
    }
    $stmt->close();

    $conn->close();

    echo "Thank you for your feedback!";
}
?>
