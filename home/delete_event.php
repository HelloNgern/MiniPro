<?php
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

// ตรวจสอบว่า session มีค่า user_id หรือไม่
if (!isset($_SESSION['id'])) {
    die("Error: User not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event_id'])) {
    $eventId = $_POST['event_id'];

    // ลบ event ที่มี id ตรงกับที่ส่งมา
    $sql = "DELETE FROM events WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $eventId, $_SESSION['id']);
    
    if ($stmt->execute()) {
        echo 'success'; // ส่งข้อความสำเร็จกลับไป
    } else {
        echo 'error';
    }

    $stmt->close();
}

$conn->close();
?>
