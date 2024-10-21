<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึง user_id จาก session
$userId = $_SESSION['id'];
date_default_timezone_set('Asia/Bangkok');
$current_time = time();  // เวลาปัจจุบันใน timestamp

// SQL Query เพื่อดึงกิจกรรมที่ยังไม่เสร็จ
$sql = "SELECT id,title, start_time 
        FROM events 
        WHERE user_id = ? 
        AND UNIX_TIMESTAMP(start_time) > ? 
        AND status = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $current_time);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];

if ($result->num_rows > 0) {
    while ($event = $result->fetch_assoc()) {
        $start_time = strtotime($event['start_time']);  // แปลงเวลาของกิจกรรมเป็น timestamp

        // คำนวณเวลาที่เหลืออยู่
        $remaining_time = $start_time - $current_time;  // คำนวณเวลาที่เหลือเป็นวินาที
        $minutes_remaining = floor($remaining_time / 60);  // แปลงเป็นนาที

        // ตรวจสอบกิจกรรมที่จะเริ่มใน 1 ชั่วโมงและ 30 นาที
        if ($minutes_remaining <= 60 && $minutes_remaining > 0) {
            $notifications[] = [
                'id' => $event['id'],
                'title' => $event['title'],
                'remaining' => $minutes_remaining
            ];
        }
    }
}

// ส่งข้อมูลกลับไปในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($notifications);

$stmt->close();
$conn->close();
?>
