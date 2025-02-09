<?php
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

if (isset($_GET['username'])) {
    $username = $conn->real_escape_string($_GET['username']);

    // Fetch the user details based on the username
    $sql = "SELECT name, phone, username, email, experience, awards, about FROM artist_request WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No user found";
        exit;
    }
} else {
    echo "Invalid request";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Artist Details</h2>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                <p><strong>Experience:</strong> <?php echo htmlspecialchars($row['experience']); ?>years</p>
                <p><strong>Awards:</strong> <?php echo htmlspecialchars($row['awards']); ?></p>
                <p><strong>About:</strong> <?php echo htmlspecialchars($row['about']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
