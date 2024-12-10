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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username']) && isset($_GET['art_id'])) {
        $product_id = $_GET['art_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $street = $_POST['street'];
        $pincode = $_POST['pincode'];
        $landmark = $_POST['landmark'];
        $house_number = $_POST['houseNumber'];
        $city = $_POST['city'];
        $state = $_POST['state'];

        $stmt = $conn->prepare("INSERT INTO art_requests (product_id, name, email, phone, street, pincode, landmark, house_number, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssss", $product_id, $name, $email, $phone, $street, $pincode, $landmark, $house_number, $city, $state);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Order placed successfully.');
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

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
    crossorigin="anonymous"
  />

  <title>Art Gallery Order Form</title>
  <style>
    body{
        background: url('background1.jpg') no-repeat ;
        background-size:cover;
        background-position: center;
        backdrop-filter: blur(10px);
    }
    .heading {
      text-align: center;
      margin-bottom: 20px;
      color: black;
    }

    form {
      max-width: 600px; /* Reduce the width of the form */
      padding: 15px; /* Reduce padding */
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 20px auto; /* Center the form */
      font-size: 16px; /* Reduce font size */
    }

    input[type=text], input[type=email], input[type=tel], input[type=number], select, textarea {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 14px; /* Reduce input font size */
    }

    input[type=submit] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px; /* Reduce padding */
      border: none;
      border-radius: 4px;
      cursor: pointer;
      float: right;
    }

    input[type=submit]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <form action="" method="post" class="needs-validation" novalidate>
    <h2 style="text-align: center">Order Form</h2>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" required>

    <label for="street">Street:</label>
    <input type="text" id="street" name="street" required>

    <label for="pincode">Pincode (6 digits):</label>
    <input type="text" id="pincode" name="pincode" pattern="[0-9]{6}" required>

    <label for="landmark">Landmark:</label>
    <input type="text" id="landmark" name="landmark">

    <label for="house-number">House Number:</label>
    <input type="text" id="house-number" name="houseNumber">

    <label for="city">City/Town:</label>
    <input type="text" id="city" name="city" required>

    <label for="state">State:</label>
    <input type="text" id="state" name="state" required>

    <div class="col-md-12 m-2">
      <button id="submitBtn" class="btn btn-primary" type="submit">Confirm Order</button>
    </div>
  </form>

  <script>
    const form = document.querySelector("form");

    form.addEventListener(
      "submit",
      (e) => {
        if (!form.checkValidity()) {
          e.preventDefault();
          e.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  </script>
</body>
</html>
