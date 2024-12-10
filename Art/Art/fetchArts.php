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

$art_type = isset($_GET['art_type']) ? $_GET['art_type'] : 'NO FILTER';

if ($art_type === 'NO FILTER') {
    $sql = "SELECT * FROM art_uploads";
} else {
    $sql = "SELECT * FROM art_uploads WHERE type_of_art = '$art_type' OR other_type = '$art_type'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '
        <div class="col-md-4">
            <div class="card shadow-lg">
                <img src="' . $row["picture"] . '" class="card-img-top" alt="' . $row["art_name"] . '">
                <div class="card-body">
                    <h5 class="card-title">' . $row["art_name"] . '</h5>
                    <p class="card-text"><strong>Artist:</strong> ' . $row["username"] . '</p>
                    <p class="card-text"><strong>Description:</strong> ' . $row["description"] . '</p>
                    <p class="card-text"><strong>Date:</strong> ' . $row["date"] . '</p>
                    <p class="card-text"><strong>Type:</strong> ' . ($row["type_of_art"] == "other" ? $row["other_type"] : $row["type_of_art"]) . '</p>
                    <p class="card-text"><strong>Price:</strong> $' . $row["price"] . '</p>
                    <a href="order.php?art_id=' . $row["product_id"] . '" class="btn btn-primary">Order</a>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<p>No art pieces found.</p>';
}

$conn->close();
?>
