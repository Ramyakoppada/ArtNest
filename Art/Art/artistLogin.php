<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);

    $conn = openConnection(); 
    $sql = "SELECT phone FROM artist WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_phone);
        $stmt->fetch();

        if ($phone === $stored_phone) {
            $_SESSION['username'] = $username;
            header("Location: craftsmenIndex.html");
            exit();
        } else{
            echo "<script>
        alert('Wrong password.');
        window.location.href='artistLogin.html';
      </script>";
        }
exit();
}
 else {
echo "<script>
    alert(\"Username doesn't exist.\");
    window.location.href='artistLogin.html';
  </script>";
exit();
    }

    $stmt->close();
    $conn->close();
}
?>
