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

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO artist_request (username, name, email, phone, experience, awards, about) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssiss", $username, $name, $email, $phone, $experience, $awards, $about);

// Set parameters and execute
$username = $_POST['username'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$experience = $_POST['experience'];
$awards = $_POST['awards'];
$about = $_POST['about'];

if ($stmt->execute()) {
    echo "<script>
                alert(\"Details submitted successfully\");
                window.location.href='craftsmenIndex.html';
              </script>";
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
