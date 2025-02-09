<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "User not logged in.";
    exit();
}

$username = $_SESSION['username'];

$servername = "localhost";
$username_db = "root";
$password_db = "Praneetha@1";
$dbname = "artgallery";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, phone, email, experience, awards, about FROM artist WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($name, $phone, $email, $experience, $awards, $about);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Artist Details</title>
</head>
<body>
<div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>My Profile</h2>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Experience:</strong> <?php echo nl2br(htmlspecialchars($experience)); ?></p>
                <p><strong>Awards:</strong> <?php echo nl2br(htmlspecialchars($awards)); ?></p>
                <p><strong>About:</strong> <?php echo nl2br(htmlspecialchars($about));?></p>
            </div>
        </div>
    </div>
</body>
</html>
