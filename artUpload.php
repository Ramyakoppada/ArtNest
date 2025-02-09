<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "Praneetha@1";
$dbname = "artgallery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $art_name = $_POST['art_name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $type_of_art = $_POST['type_of_art'];
    $other_type = isset($_POST['other_type']) ? $_POST['other_type'] : null;
    $price = $_POST['price'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($_FILES["picture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    if(!in_array($imageFileType, $allowed_extensions)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";

    } else {
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {

            $stmt = $conn->prepare("INSERT INTO art_uploads (username, art_name, description, date, type_of_art, other_type, picture, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssd", $username, $art_name, $description, $date, $type_of_art, $other_type, $target_file, $price);

            if ($stmt->execute()) {
                echo "<script>
                        alert('The file ". htmlspecialchars(basename($_FILES["picture"]["name"]))." has been uploaded successfully.');
                        window.location.href = 'artistDetails.php';
                      </script>";
                $stmt->close();
                $conn->close();
                exit();
            } else {
                echo "<br>Error inserting record: " . $stmt->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "Invalid request method.";
}

?>
