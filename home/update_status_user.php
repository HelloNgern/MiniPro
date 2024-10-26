<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าจาก JavaScript เพื่ออัปเดตสถานะ
$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['status']) && isset($data['userId'])) {
    $status = $data['status'];
    $userId = $data['userId'];
    $sql_update_status = "UPDATE users SET status = '$status' WHERE id = '$userId'";
    $conn->query($sql_update_status);
}

$conn->close();
?>
