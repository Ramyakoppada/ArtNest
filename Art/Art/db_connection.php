<?php
function openConnection() {
    $servername = "localhost"; 
    $username = "root";
    $password = "Harshi#2005"; 
    $dbname = "artgallery"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
