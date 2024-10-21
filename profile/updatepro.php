<?php
session_start();
if ($_SESSION['id'] == "") {
    header("Location: login.html"); // เปลี่ยนเส้นทางไปยังหน้า login.html
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

$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$profile_pic = $_FILES['profile_pic'];

// ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
if ($profile_pic['error'] == UPLOAD_ERR_OK) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($profile_pic['name']);
    
    // ตรวจสอบชนิดไฟล์ (เพิ่มการตรวจสอบชนิดไฟล์ที่เหมาะสม)
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowed_types)) {
        // อัปโหลดไฟล์
        if (move_uploaded_file($profile_pic['tmp_name'], $target_file)) {
            // ถ้าการอัปโหลดไฟล์สำเร็จ
            $sql = "UPDATE users SET username = '$username', email = '$email', password = '$password', profile_pic = '" . basename($profile_pic['name']) . "' WHERE id = '$id'";
            if (mysqli_query($conn, $sql)) {
                // อัปเดตข้อมูลสำเร็จ
                header("Location: profile.php");
                exit();
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
} else {
    // ถ้าไม่มีการอัปโหลดรูปภาพ
    $sql = "UPDATE users SET username = '$username', email = '$email', password = '$password' WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
