<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Harshi#2005";
$dbname = "artgallery";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    die("Unauthorized access.");
}

if (!isset($_GET['username'])) {
    die("Invalid request.");
}

$requester_username = $_GET['username'];

// Fetch the request details
$sql = "SELECT ar.product_id, ar.name, ar.email, ar.phone, ar.street, ar.pincode, ar.landmark, ar.house_number, ar.city, ar.state
        FROM art_requests ar
        JOIN user u ON ar.name = u.username
        WHERE ar.name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $requester_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No request details found for the user.");
}

$request_details = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>View Request Details</title>
    <style>
        body {
            background: url('background.jpeg') no-repeat;
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(10px);
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
            margin-top: 50px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container shadow-lg">
        <h2>Request Details</h2>
        <form>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($request_details['name']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($request_details['email']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($request_details['phone']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Street:</label>
                <input type="text" class="form-control" id="street" name="street" value="<?php echo htmlspecialchars($request_details['street']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="pincode" class="form-label">Pincode:</label>
                <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo htmlspecialchars($request_details['pincode']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="landmark" class="form-label">Landmark:</label>
                <input type="text" class="form-control" id="landmark" name="landmark" value="<?php echo htmlspecialchars($request_details['landmark']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="house_number" class="form-label">House Number:</label>
                <input type="text" class="form-control" id="house_number" name="house_number" value="<?php echo htmlspecialchars($request_details['house_number']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City:</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($request_details['city']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State:</label>
                <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($request_details['state']); ?>" readonly>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
