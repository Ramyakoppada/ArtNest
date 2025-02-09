<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Praneetha@1";
$dbname = "artgallery";
function connectDB() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
include 'emailTesting.php';

if (!isset($_SESSION['username'])) {
    die("Session username not set.");
}

if (isset($_GET['action']) && $_GET['action'] === 'deny' && isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    $conn = connectDB();
    $conn->begin_transaction();

    try {
        $sql = "SELECT email FROM art_requests WHERE request_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();
        $sql = "DELETE FROM art_requests WHERE request_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $request_id);
        if (!$stmt->execute()) {
            throw new Exception("Delete from art_requests failed: " . $stmt->error);
        }
        $stmt->close();
        $conn->commit();
        sendEmail($username,$email,'123','denyReq');
        echo "<script>alert('Request Denied Successfully'); 
        window.location.href='productReqDisplay.php';</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Failed to deny request: " . $e->getMessage() . "');
        window.location.href='productReqDisplay.php';</script>";
    }

    $conn->close();
    exit; 
}


if (isset($_GET['action']) && $_GET['action'] === 'accept' && isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    
    $conn = connectDB();

    
    $sql = "SELECT * FROM art_requests WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $request = $result->fetch_assoc();
    $stmt->close();

    if (!$request) {
        die("No request found with the given ID.");
    }

   
    $conn->begin_transaction();

    try {
        $sql = "INSERT INTO orders (product_id, artist_username, username, name, email, phone, pincode, flat_number, street, landmark, city, state) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("isssssssssss", 
            $request['product_id'], 
            $request['artist_username'], 
            $request['username'], 
            $request['name'], 
            $request['email'], 
            $request['phone'], 
            $request['pincode'], 
            $request['flat_number'], 
            $request['street'], 
            $request['landmark'], 
            $request['city'], 
            $request['state']);
        $email =  $request['email'];
        if (!$stmt->execute()) {
            throw new Exception("Insert into orders failed: " . $stmt->error);
        }
        $stmt->close();
        $sql = "DELETE FROM art_requests WHERE request_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $request_id);
        if (!$stmt->execute()) {
            throw new Exception("Delete from art_requests failed: " . $stmt->error);
        }
        $stmt->close();
        $conn->commit();
        sendEmail($username,$email,'123','acceptReq');
        echo "<script>alert('Request Accepted Successfully');
        window.location.href='productReqDisplay.php';</script>";
    } catch (Exception $e) {
       
        $conn->rollback();
        echo "<script>alert('Failed to accept request: " . $e->getMessage() . "');
        window.location.href='productReqDisplay.php';</script>";
    }

    $conn->close();
    exit; 
}


$artist_username = $_SESSION['username'];
$conn = connectDB();

$sql = "SELECT ar.request_id, ar.username AS requester, ar.name, ar.email, ar.phone, ar.pincode, ar.flat_number, ar.street, ar.landmark, ar.city, ar.state, au.product_id, au.picture, au.art_name 
        FROM art_requests ar 
        JOIN art_uploads au ON ar.product_id = au.product_id 
        WHERE ar.artist_username = ?";
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
    <title>View Requests</title>
    <style>
        body {
            background: url('background.jpeg') no-repeat;
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(10px);
        }
        .heading {
            text-align: center;
            margin-bottom: 20px;
            color: black;
        }
        .table-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
        .horizontal-line {
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        .btn-action {
            width: 120px; /* Ensure buttons are of the same length */
            margin-right: 10px; /* Gap between the buttons */
        }

        .btn-danger.btn-action {
            margin-right: 0; /* Ensure the last button doesn't have extra margin */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="heading">
            <h1>View Art Requests</h1>
        </div>
        <div class="table-container shadow-lg">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Email ID</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Product</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $sno = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $sno++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['requester']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td>";
                            echo htmlspecialchars($row['flat_number']) . ", " . htmlspecialchars($row['street']) . ", " . htmlspecialchars($row['landmark']) . ", " . htmlspecialchars($row['city']) . ", " . htmlspecialchars($row['state']) . " - " . htmlspecialchars($row['pincode']);
                            echo "</td>";
                            echo "<td>";
                            echo "<img src='" . htmlspecialchars($row['picture']) . "' alt='" . htmlspecialchars($row['art_name']) . "' style='width: 100px; height: auto;'><br>";
                            echo htmlspecialchars($row['art_name']);
                            echo "</td>";
                            echo "<td>";
                            echo "<button class='btn btn-success btn-action' onclick='acceptRequest(\"accept\", " . $row['request_id'] . ")'>Accept</button>";
                            echo "<button class='btn btn-danger btn-action' onclick='denyRequest(\"deny\", " . $row['request_id'] . ")'>Deny</button>";
                            echo "</td>";
                            echo "</tr>";
                            echo "<tr><td colspan='7' class='horizontal-line'></td></tr>"; // Horizontal line after each row
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No requests found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function denyRequest(action, requestId) {
            if (action === 'deny' && confirm('Are you sure you want to deny this request?')) {
                window.location.href = '?action=deny&request_id=' + encodeURIComponent(requestId);
            }
        }
        function acceptRequest(action, requestId) {
            if (action === 'accept' && confirm('Are you sure you want to accept this request?')) {
                window.location.href = '?action=accept&request_id=' + encodeURIComponent(requestId);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
