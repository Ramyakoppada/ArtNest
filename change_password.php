<?php
session_start();
include 'db_connection.php';

$response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $currentPassword = trim($_POST['currentPassword']);
    $newPassword = trim($_POST['newPassword']);
    $confirmNewPassword = trim($_POST['confirmNewPassword']);

    if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit();
    }

    if ($newPassword !== $confirmNewPassword) {
        $response['message'] = 'New passwords do not match.';
        echo json_encode($response);
        exit();
    }

    $conn = openConnection();

    // Get current password from database
    $sql = "SELECT password FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();
    $stmt->close();

    // Compare current password
    if ($currentPassword !== $storedPassword) {
        $response['message'] = 'Current password is incorrect.';
        echo json_encode($response);
        $conn->close();
        exit();
    }

    // Update password
    $sql_update = "UPDATE user SET password = ? WHERE username = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ss", $newPassword, $username);

    if ($stmt_update->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Password changed successfully.';
    } else {
        $response['message'] = 'Failed to change password.';
    }

    $stmt_update->close();
    $conn->close();
    echo json_encode($response);
}
?>
