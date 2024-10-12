<?php
// editmember.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId']; // รับค่า userId จากฟอร์ม
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    // หากมีการกรอก password ใหม่ จะทำการอัปเดตด้วย
    if (!empty($password)) {
        // แฮช password ใหม่
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username='$username', email='$email', password='$hashedPassword', role='$role', status='$status' WHERE id='$userId'";
    } else {
        // ถ้าไม่กรอก password ใหม่ ให้ไม่อัปเดต password
        $sql = "UPDATE users SET username='$username', email='$email', role='$role', status='$status' WHERE id='$userId'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'แก้ไขข้อมูลสมาชิกสำเร็จ!',
            text: 'ข้อมูลถูกแก้ไขแล้ว',
            icon: 'success',
            timer: 2000, // หน่วงเวลา 3 วินาที
            showConfirmButton: false, // ซ่อนปุ่มยืนยัน
            willClose: () => {
                window.location.href = 'dashboard.php'; 
            }
        });
    </script>";
        // Redirect หรือแสดงข้อความที่ต้องการ
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>
