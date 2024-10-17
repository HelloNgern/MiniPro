<?php
session_start();
header('Content-Type: application/json');

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "login_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจาก AJAX
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// ตรวจสอบว่ามี event_id หรือไม่
if (isset($data['id'])) {
    $event_id = $data['id'];

    // SQL สำหรับลบกิจกรรมจากรายการโปรด
    $sql = "UPDATE events SET liked=liked-1 WHERE user_id = ? AND id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $_SESSION['id'], $event_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

$conn->close();
?>
