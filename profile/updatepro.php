<?php
session_start();
if ($_SESSION['id'] == "") {
    echo "กรุณา login ก่อน";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// รับค่าจากฟอร์มที่ส่งมา
$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password =  password_hash($_POST['password'], PASSWORD_DEFAULT);

// ตรวจสอบว่าค่า UserID ไม่ว่างเปล่า
if (!empty($id)) {
    // ตรวจสอบว่า Username ที่ต้องการแก้ไขนั้นซ้ำกับผู้ใช้อื่นหรือไม่
    $check_sql = "SELECT * FROM users WHERE email = '$email' AND id != '$id'";
    $check_query = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_query) > 0) {
        // หาก Username ซ้ำกับผู้ใช้อื่น ให้ส่งข้อมูลกลับไปหน้า editpro.php พร้อมข้อความแจ้งเตือน
        header("Location: editpro4ew3.php?error=username_exists");
        exit();
    } else {
        // อัปเดตข้อมูลในฐานข้อมูล
        $sql = "UPDATE users SET 
                username = '$username',
                email = '$email',
                password = '$password'
                WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) { 
            echo "<script>alert('ข้อมูลถูกแก้ไขเรียบร้อยแล้ว');</script>";
            // ทำการแยกประเภท USER หลังอัปเดตข้อมูล หากเป็น ADMIN ให้กลับไปหน้าของ ADMIN
            if ($_SESSION['role'] == "1"){
                echo "<script>window.location.href = 'profilead.php';</script>";
            }else{
                echo "<script>window.location.href = 'profile.php';</script>";
            }
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
} else {
    echo "Error: UserID is empty.";
}

mysqli_close($conn);
?>
