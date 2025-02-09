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

// Fetch number of artists
$artistCountQuery = "SELECT COUNT(*) as count FROM artist";
$artistCountResult = $conn->query($artistCountQuery);
$artistCount = $artistCountResult->fetch_assoc()['count'];

// Fetch number of users
$userCountQuery = "SELECT COUNT(*) as count FROM user";
$userCountResult = $conn->query($userCountQuery);
$userCount = $userCountResult->fetch_assoc()['count'];

// Fetch number of active requests
$requestCountQuery = "SELECT COUNT(*) as count FROM artist_request";
$requestCountResult = $conn->query($requestCountQuery);
$requestCount = $requestCountResult->fetch_assoc()['count'];

// Fetch number of products
$productCountQuery = "SELECT COUNT(*) as count FROM art_uploads";
$productCountResult = $conn->query($productCountQuery);
$productCount = $productCountResult->fetch_assoc()['count'];

// Fetch number of sales
$salesCountQuery = "SELECT COUNT(*) as count FROM orders";
$salesCountResult = $conn->query($salesCountQuery);
$salesCount = $salesCountResult->fetch_assoc()['count'];

// Fetch top artist by average rating
$topArtistQuery = "
    SELECT artist_username, AVG(rating) as average_rating
    FROM artist_rating
    GROUP BY artist_username
    ORDER BY average_rating DESC
    LIMIT 1
";
$topArtistResult = $conn->query($topArtistQuery);

$topArtistName = "N/A";
$topArtistRating = "N/A";

if ($topArtistResult->num_rows > 0) {
    $topArtistRow = $topArtistResult->fetch_assoc();
    $topArtistName = $topArtistRow['artist_username'];
    $topArtistRating = number_format($topArtistRow['average_rating'], 2); // Format the rating to 2 decimal places
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f9;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: -20px; /* Move cards up */
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: calc(33.333% - 20px);
            box-sizing: border-box;
            text-align: center;
            font-size: 18px;
            height: 180px;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #34495e;
        }

        .card h3 {
            margin: 10px 0;
            font-weight: 500;
            font-size: 24px;
            color: #333;
        }

        .card p {
            font-size: 20px;
            font-weight: 700;
            color: #666;
        }

        .card-1 {
            background-color: #e74c3c;
            color: #fff;
        }

        .card-1 i, .card-1 h3, .card-1 p {
            color: #fff;
        }

        .card-2 {
            background-color: #3498db;
            color: #fff;
        }

        .card-2 i, .card-2 h3, .card-2 p {
            color: #fff;
        }

        .card-3 {
            background-color: #2ecc71;
            color: #fff;
        }

        .card-3 i, .card-3 h3, .card-3 p {
            color: #fff;
        }

        .card-4 {
            background-color: #f1c40f;
            color: #fff;
        }

        .card-4 i, .card-4 h3, .card-4 p {
            color: #fff;
        }

        .card-5 {
            background-color: #9b59b6;
            color: #fff;
        }

        .card-5 i, .card-5 h3, .card-5 p {
            color: #fff;
        }

        .card-6 {
            background-color: #e67e22;
            color: #fff;
        }

        .card-6 i, .card-6 h3, .card-6 p {
            color: #fff;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .card {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .card {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="card-container">
            <div class="card card-1">
                <i class="fas fa-palette"></i>
                <h3>Number of Artists</h3>
                <p><?php echo $artistCount; ?></p>
            </div>
            <div class="card card-2">
                <i class="fas fa-users"></i>
                <h3>Number of Users</h3>
                <p><?php echo $userCount; ?></p>
            </div>
            <div class="card card-3">
                <i class="fas fa-tasks"></i>
                <h3>Number of Active Requests</h3>
                <p><?php echo $requestCount; ?></p>
            </div>
            <div class="card card-4">
                <i class="fas fa-box"></i>
                <h3>Number of Products</h3>
                <p><?php echo $productCount; ?></p>
            </div>
            <div class="card card-5">
                <i class="fas fa-chart-line"></i>
                <h3>Number of Sales</h3>
                <p><?php echo $salesCount; ?></p>
            </div>
            <div class="card card-6">
                <i class="fas fa-crown"></i>
                <h3>Top Artist by Rating</h3>
                <p><?php echo htmlspecialchars($topArtistName); ?> (Rating: <?php echo htmlspecialchars($topArtistRating); ?>)</p>
            </div>
        </div>
    </div>
</body>
</html>
