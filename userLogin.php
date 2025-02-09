<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $conn = openConnection(); 
    $sql = "SELECT password FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        if ($password === $stored_password) {
            $_SESSION['username'] = $username; // Set session variable
            header("Location: h.php");
            exit();
        } else {
            $_SESSION['loginError'] = 'Wrong password.';
            echo "<script>
    alert(\"Wrong password.\");
    window.location.href='artistLogin.html';
  </script>";
            
            exit();
        }
    } else {
        $_SESSION['loginError'] = "Username doesn't exist.";
        echo "<script>
    alert(\"Username doesn't exist.\");
    window.location.href='userLogin.html';
  </script>";
        
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
