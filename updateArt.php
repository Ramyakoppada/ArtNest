<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "Praneetha@1";
$dbname = "artgallery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    die("Session username not set.");
}

$artist_username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $art_id = $_POST['art_id'];
    $art_name = $_POST['art_name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $type_of_art = $_POST['type_of_art'];
    $other_type = isset($_POST['other_type']) ? $_POST['other_type'] : '';
    $price = $_POST['price'];

    // Handle file upload for picture
    if ($_FILES['picture']['error'] == UPLOAD_ERR_OK && isset($_FILES['picture']['tmp_name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["picture"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                // Update database with new picture path
                $picture_path = $target_file;
                $sql = "UPDATE art_uploads SET art_name=?, description=?, date=?, type_of_art=?, other_type=?, price=?, picture=? WHERE product_id=? AND username=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssssss", $art_name, $description, $date, $type_of_art, $other_type, $price, $picture_path, $art_id, $artist_username);
                if ($stmt->execute()) {
                    header("Location: manageArts.php");
                    exit();
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update database without changing picture
        $sql = "UPDATE art_uploads SET art_name=?, description=?, date=?, type_of_art=?, other_type=?, price=? WHERE product_id=? AND username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $art_name, $description, $date, $type_of_art, $other_type, $price, $art_id, $artist_username);
        if ($stmt->execute()) {
            header("Location: manageArts.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>
