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

$message = '';

if (isset($_GET['action']) && isset($_GET['username'])) {
    $action = $_GET['action'];
    $username = $conn->real_escape_string($_GET['username']);

    if ($action == 'accept') {
        // Fetch the artist details from artist_request table
        $sql = "SELECT * FROM artist_request WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Insert the artist details into the artist table
            $name = $conn->real_escape_string($row['name']);
            $phone = $conn->real_escape_string($row['phone']);
            $email = $conn->real_escape_string($row['email']);
            $experience = $conn->real_escape_string($row['experience']);
            $awards = $conn->real_escape_string($row['awards']);
            $about = $conn->real_escape_string($row['about']);

            $insertSql = "INSERT INTO artist (username, name, phone, email, experience, awards, about)
                          VALUES ('$username', '$name', '$phone', '$email', '$experience', '$awards', '$about')";

            if ($conn->query($insertSql) === TRUE) {
                // Delete the artist request from artist_request table
                $deleteSql = "DELETE FROM artist_request WHERE username = '$username'";
                if ($conn->query($deleteSql) === TRUE) {
                    $message = "Request accepted.";
                } else {
                    $message = "Error: " . $deleteSql . "<br>" . $conn->error;
                }
            } else {
                $message = "Error: " . $insertSql . "<br>" . $conn->error;
            }
        }
    } elseif ($action == 'deny') {
        // Delete the artist request from artist_request table
        $deleteSql = "DELETE FROM artist_request WHERE username = '$username'";
        if ($conn->query($deleteSql) === TRUE) {
            $message = "Request denied";
        } else {
            $message = "Error: " . $deleteSql . "<br>" . $conn->error;
        }
    }
}

$conn->close();

header("Location: artistReqDisplay.php?message=" . urlencode($message));
exit();
?>
