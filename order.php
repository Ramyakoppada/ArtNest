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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username']) && isset($_GET['art_id'])) {
        $product_id = $_GET['art_id'];
        $user_username = $_SESSION['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $street = $_POST['street'];
        $pincode = $_POST['pincode'];
        $landmark = $_POST['landmark'];
        $house_number = $_POST['flatNumber'];
        $city = $_POST['city'];
        $state = $_POST['state'];

        
        $stmt = $conn->prepare("SELECT username FROM art_uploads WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->bind_result($artist_username);
        $stmt->fetch();
        $stmt->close();

        if (!$artist_username) {
            die("Artist not found for the given product.");
        }

        
$stmt = $conn->prepare("INSERT INTO art_requests (product_id, username, artist_username, name, email, phone, pincode, flat_number, street, landmark, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssssssss", $product_id, $user_username, $artist_username, $name, $email, $phone, $pincode, $house_number, $street, $landmark, $city, $state);

        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Order request sent to the artist.');
                    window.location.href = 'arts.php';
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "User not logged in or invalid request.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
  <title>Art Gallery Order Form</title>
  <style>
    body {
        background: url('background.jpeg') no-repeat;
        background-size: cover;
        background-position: center;
        backdrop-filter: blur(10px);
        font-family: Arial, sans-serif;
    }

    .heading {
      text-align: center;
      margin-bottom: 20px;
      color: black;
    }

    form {
      max-width: 600px;
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 20px auto;
      font-size: 16px;
    }

    input[type=text], input[type=email], input[type=tel], input[type=number], select, textarea {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 14px;
    }

    input[type=submit] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      float: right;
    }

    input[type=submit]:hover {
      background-color: #45a049;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
  </style>
</head>
<body>

  <form id="orderForm" action="" method="post" class="needs-validation" novalidate>
    <h2 class="heading">Order Form</h2>

    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" name="phone" required>
    </div>

    <div class="form-group">
      <label for="pincode">Pincode (6 digits)</label>
      <input type="text" id="pincode" name="pincode" pattern="[0-9]{6}" required>
    </div>

    <div class="form-group">
      <label for="flat-number">Flat Number</label>
      <input type="text" id="flat-number" name="flatNumber" required>
    </div>

    <div class="form-group">
      <label for="street">Street</label>
      <input type="text" id="street" name="street" required>
    </div>

    <div class="form-group">
      <label for="landmark">Landmark</label>
      <input type="text" id="landmark" name="landmark" required>
    </div>

    <div class="form-group">
      <label for="city">City</label>
      <input type="text" id="city" name="city" required>
    </div>

    <div class="form-group">
      <label for="state">State</label>
      <input type="text" id="state" name="state" required>
    </div>

    <div class="col-md-12 m-2">
      <button id="submitBtn" class="btn btn-primary" type="submit">Confirm Order</button>
    </div>
  </form>

  <script>
    document.getElementById('orderForm').addEventListener('submit', function(event) {
      // Check if form is valid
      const form = this;
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
        
        // Alert the user
        alert('Please fill out all required fields.');
        
        // Highlight invalid fields
        form.classList.add('was-validated');
      } else {
        // Remove 'was-validated' class if form is valid
        form.classList.remove('was-validated');
      }
    }, false);
  </script>
</body>
</html>
