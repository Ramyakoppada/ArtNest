<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Harshi#2005";
$dbname = "artgallery";

// Function to connect to the database
function connectDB() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Check if session username is set
if (!isset($_SESSION['username'])) {
    die("Session username not set.");
}

// Check if deny action is triggered
if (isset($_GET['action']) && $_GET['action'] === 'deny' && isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    
    $conn = connectDB();

    $sql = "DELETE FROM art_requests WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Request Denied Successfully');
        window.location.href='productReqDisplay.php';</script>";
    } else {
        echo "<script>alert('Failed to deny request.');
        window.location.href='productReqDisplay.php';</script>";
    }

    $stmt->close();
    $conn->close();
    exit; 
}

if (isset($_GET['action']) && $_GET['action'] === 'accept' && isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    
    $conn = connectDB();

    $sql = "DELETE FROM art_requests WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Request Accepted Successfully');
        window.location.href='productReqDisplay.php';</script>";
    } else {
        echo "<script>alert('Failed to accept request.');
        window.location.href='productReqDisplay.php';</script>";
    }

    $stmt->close();
    $conn->close();
    exit; 
}

// Fetch requests to display
$artist_username = $_SESSION['username'];
$conn = connectDB();

$sql = "SELECT ar.request_id, ar.name AS requester, u.email 
        FROM art_requests ar 
        JOIN art_uploads au ON ar.product_id = au.product_id 
        JOIN user u ON ar.name = u.username
        WHERE au.username = ?";
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
                            echo "<td>";
                            echo "<a href='viewDetails.php?username=" . htmlspecialchars($row['requester'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-info'>View Details</a> ";
                            echo "<button class='btn btn-success' onclick='acceptRequest(\"accept\", " . $row['request_id'] . ")'>Accept</button> ";
                            echo "<button class='btn btn-danger' onclick='denyRequest(\"deny\", " . $row['request_id'] . ")'>Deny</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No requests found</td></tr>";
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

<?php
$stmt->close();
$conn->close();
?>
