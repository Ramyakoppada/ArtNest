<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $conn = openConnection(); 
    $sql = "SELECT password FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        if ($password === $stored_password) {
            $_SESSION['username'] = $username;
            header("Location: index.html");
            exit();
        } else {
            echo "<script>
                    alert('Wrong password.');
                    window.location.href='adminLogin.html';
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                alert(\"Username doesn't exist.\");
                window.location.href='adminLogin.html';
              </script>";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
