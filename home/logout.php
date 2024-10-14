<?php
session_start(); // เริ่ม session
session_unset(); // ลบข้อมูล session
session_destroy(); // ทำลาย session

// เปลี่ยนเส้นทางไปยังหน้า login.php
header("Location: ../register/login.html");
exit(); // ออกจาก script
?>
