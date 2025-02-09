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

// Set parameters from POST request
$username = $_POST['username'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$experience = $_POST['experience'];
$awards = $_POST['awards'];
$about = $_POST['about'];

// Check if username or email already exists
$checkQuery = "SELECT * FROM artist WHERE username = ? OR email = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>
                alert(\"Username or Email already exists. Please try a different one.\");
                window.history.back();
          </script>";
    $stmt->close();
    $conn->close();
    exit();
} else {
    // Prepare and bind insert statement
    $insertQuery = "INSERT INTO artist_request (username, name, email, phone, experience, awards, about) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssssiss", $username, $name, $email, $phone, $experience, $awards, $about);

    if ($stmt->execute()) {
        echo "<script>
                    alert(\"Details submitted successfully\");
                    window.location.href='h.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
