<?php
$servername = "localhost";
$username = "root";
$password = "Praneetha@1";
$dbname = "artgallery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username, name, phone FROM artist";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Artists</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h1>Manage Artists</h1>
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
                            // echo "<button class='btn btn-info' onclick='editArtist(\"" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "\")'>Edit</button> ";
                            echo "<button class='btn btn-danger' onclick='deleteArtist(\"" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "\")'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No artists found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>

        function deleteArtist(username) {
            if (confirm('Are you sure you want to delete this artist?')) {
                window.location.href = 'deleteArtist.php?username=' + encodeURIComponent(username);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
