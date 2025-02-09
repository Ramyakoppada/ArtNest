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

$sql = "SELECT * FROM art_uploads WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $artist_username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>View Uploaded Arts</title>
    <style>
        body {
            background: url('background.jpeg') no-repeat;
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(10px);
        }
        .card {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }
        .card .card-img-top {
            max-height: 300px; /* Adjust this value as needed */
            max-width: 100%; /* Ensures image does not overflow card width */
            object-fit: cover; /* Maintains aspect ratio and covers the entire space */
        }
        .card-body {
            flex-grow: 1;
        }
        .card-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="col-md-4 card-container">
                        <div class="card shadow-lg">
                            <img src="' . $row["picture"] . '" class="card-img-top" alt="' . $row["art_name"] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $row["art_name"] . '</h5>
                                <p class="card-text"><strong>Artist:</strong> ' . $row["username"] . '</p>
                                <p class="card-text"><strong>Description:</strong> ' . $row["description"] . '</p>
                                <p class="card-text"><strong>Date:</strong> ' . $row["date"] . '</p>
                                <p class="card-text"><strong>Type:</strong> ' . ($row["type_of_art"] == "other" ? $row["other_type"] : $row["type_of_art"]) . '</p>
                                <p class="card-text"><strong>Price:</strong> ₹' . $row["price"] . '</p>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-md-12"><p class="text-center">No art pieces found.</p></div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
