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

// Fetch all artist requests
$sql = "SELECT name, phone, username, email, experience, awards, about FROM artist_request";
$result = $conn->query($sql);

$message = '';
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Artist Requests</title>
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
            <h1>Artist Requests</h1>
        </div>
        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <div class="table-container shadow-lg">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $sno = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $sno++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td>";
                            echo "<a href='viewDetails.php?username=" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-info'>View Details</a> ";
                            echo "<button class='btn btn-success' onclick='acceptRequest(\"" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "\")'>Accept</button> ";
                            echo "<button class='btn btn-danger' onclick='denyRequest(\"" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "\")'>Deny</button>";
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
        function acceptRequest(username) {
            if (confirm('Are you sure you want to accept this request?')) {
                window.location.href = 'handleRequest.php?action=accept&username=' + encodeURIComponent(username);
            }
        }

        function denyRequest(username) {
            if (confirm('Are you sure you want to deny this request?')) {
                window.location.href = 'handleRequest.php?action=deny&username=' + encodeURIComponent(username);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
