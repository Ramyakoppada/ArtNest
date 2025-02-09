<?php
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$conn = new mysqli('localhost', 'root', 'Praneetha@1', 'artgallery');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT username, email FROM user WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($existingUsername, $existingEmail);
    $stmt->fetch();

    if ($existingUsername === $username) {
        echo "<script>
            alert('Username already exists, try out a new one.');
            window.history.back();
        </script>";
    } elseif ($existingEmail === $email) {
        echo "<script>
            alert('Email already exists, try out a new one.');
            window.history.back();
        </script>";
    }
} else {
    $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "<script>
                    alert('Sign Up Successful.');
                    window.location.href='userLogin.html';
                  </script>";
            exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
