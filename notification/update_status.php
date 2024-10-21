<?php
session_start();
if (!isset($_SESSION['id'])) {
    die("Error: User not logged in.");
}

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีข้อมูลที่ส่งมาจาก AJAX หรือไม่
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    

    // อัปเดตสถานะของกิจกรรมในฐานข้อมูล
    $query = "UPDATE events SET status = 2 WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $id, $_SESSION['id']);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        http_response_code(500); // ส่งกลับ 500 ถ้าเกิดข้อผิดพลาด
        echo 'error';
    }

    $stmt->close();
} else {
    http_response_code(400); // ส่งกลับ 400 ถ้าไม่มีข้อมูลที่ต้องการ
    echo 'Invalid request';
}
?>
