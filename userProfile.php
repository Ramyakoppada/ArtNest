<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['username'])) {
    echo "<p>Please log in to view your profile.</p>";
    exit();
}

$username = $_SESSION['username'];

// Establish database connection
$conn = openConnection();

// Fetch user details
$sql = "SELECT email FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

// Fetch user orders
$sql = "SELECT o.product_id, o.name, o.email, o.phone, o.pincode, o.flat_number, o.street, o.landmark, o.city, o.state, o.order_date,
               a.art_name, a.picture, a.price, a.description, a.type_of_art, a.username as artist_username
        FROM orders o
        JOIN art_uploads a ON o.product_id = a.product_id
        WHERE o.username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$arts = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background: url('background.jpeg') no-repeat;
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(10px);
            font-family: Times New Roman, serif;
        }
        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .back-home-btn {
            margin-bottom: 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .back-home-btn:hover {
            background-color: #0056b3;
        }
        .profile-box, .purchases-section {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 10px;
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 350px;
            height: auto;
            box-sizing: border-box;
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .stars-container .fa-star {
            cursor: pointer;
            font-size: 20px;
        }
        .checked {
            color: orange;
        }
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1;
            overflow: auto;
        }
        .popup-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }
        .close {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-box">
        <h1>User Details</h1>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <button class="btn btn-primary" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
        <br><br>
        <button class="btn btn-primary back-home-btn" onclick="window.location.href='h.php';">
            Back to Home
        </button>
    </div>

    <div class="purchases-section">
        <h1>Purchased Arts</h1>
        <?php if (empty($arts)): ?>
            <p>No purchases yet.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($arts as $art): ?>
                    <div class="col-md-6 d-flex justify-content-center mb-4">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($art['picture']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($art['art_name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($art['art_name']); ?></h5>
                                <p class="card-text"><strong>Type:</strong> <?php echo htmlspecialchars($art['type_of_art']); ?></p>
                                <p class="card-text"><strong>Price:</strong> ₹<?php echo htmlspecialchars($art['price']); ?></p>
                                <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($art['description']); ?></p>
                                <p class="card-text"><strong>Ordered on:</strong> <?php echo htmlspecialchars($art['order_date']); ?></p>
                                
                                <!-- Rating section -->
                                <h5>Rate this Artist</h5>
                                <div class="stars-container" id="stars-container-<?php echo htmlspecialchars($art['product_id']); ?>">
                                    <span class="fa fa-star" onclick="toggleStar(this, 1, <?php echo htmlspecialchars($art['product_id']); ?>)"></span>
                                    <span class="fa fa-star" onclick="toggleStar(this, 2, <?php echo htmlspecialchars($art['product_id']); ?>)"></span>
                                    <span class="fa fa-star" onclick="toggleStar(this, 3, <?php echo htmlspecialchars($art['product_id']); ?>)"></span>
                                    <span class="fa fa-star" onclick="toggleStar(this, 4, <?php echo htmlspecialchars($art['product_id']); ?>)"></span>
                                    <span class="fa fa-star" onclick="toggleStar(this, 5, <?php echo htmlspecialchars($art['product_id']); ?>)"></span>
                                </div>
                                <button class="btn btn-primary mt-2" onclick="submitRating('<?php echo htmlspecialchars($art['artist_username']); ?>', <?php echo htmlspecialchars($art['product_id']); ?>)">Submit Rating</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Rating Popup -->
<div id="ratingPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <p id="ratingResult"></p>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
let starStates = {}; // Store rating states for each product

function toggleStar(starElement, rating, productId) {
    if (!starStates[productId]) {
        starStates[productId] = [false, false, false, false, false];
    }

    starStates[productId].fill(false);
    for (let i = 0; i < rating; i++) {
        starStates[productId][i] = true;
    }

    updateStars(productId);
}

function updateStars(productId) {
    const stars = document.querySelectorAll(`#stars-container-${productId} .fa-star`);
    const states = starStates[productId];
    stars.forEach((star, index) => {
        if (states[index]) {
            star.classList.add('checked');
        } else {
            star.classList.remove('checked');
        }
    });
}

function submitRating(artistUsername, productId) {
    let rating = starStates[productId] ? starStates[productId].filter(star => star).length : 0;
    if (rating === 0) {
        alert('Please select a rating before submitting.');
        return;
    }

    fetch('rate_artwork.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `artist_username=${encodeURIComponent(artistUsername)}&rating=${encodeURIComponent(rating)}`,
    })
    .then(response => response.text())
    .then(result => {
        document.getElementById('ratingResult').textContent = result;
        document.getElementById('ratingPopup').style.display = 'block'; // Show the popup
        starStates[productId] = [false, false, false, false, false]; // Reset stars for this product
        updateStars(productId);
    })
    .catch(error => {
        alert('Error submitting rating.');
    });
}

function closePopup() {
    document.getElementById('ratingPopup').style.display = 'none'; // Hide the popup
}
</script>
</body>
</html>
