<?php
// เชื่อมต่อกับฐานข้อมูล
session_start(); 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม

$userId = $_SESSION['id']; // สมมติว่าคุณเก็บ user_id ใน session
$title = $_POST['eventTitle'];
$location = $_POST['eventLocation'];
$details = $_POST['eventDetails'];
$color = $_POST['eventColor'];
$startTime = $_POST['eventStart'];
$endTime = $_POST['eventEnd'];
$liked = isset($_POST['likeEvent']) ? 1 : 0;
$shareEmail = $_POST['shareEmail'];

// SQL สำหรับบันทึกกิจกรรม
$sql = "INSERT INTO events (title, location, details, color, start_time, end_time, liked, share_email, user_id) 
        VALUES ('$title', '$location', '$details', '$color', '$startTime', '$endTime', '$liked', '$shareEmail', '$userId')";

if ($conn->query($sql) === TRUE) {
    echo "<<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'เพิ่มกิจกรรมสำเร็จ!',
            text: '',
            icon: 'success',
            timer: 3000, // หน่วงเวลา 3 วินาที
            showConfirmButton: false, // ซ่อนปุ่มยืนยัน
            willClose: () => {
                window.location.href = 'homepage.php'; // เปลี่ยนเส้นทางไปยังหน้า login เมื่อแจ้งเตือนปิดลง
            }
        });
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
