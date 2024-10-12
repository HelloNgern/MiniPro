<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $status = $_POST['status'];
    // เช็คว่า user หรือ email ซ้ำหรือไม่
    $check_query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "<<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'อีเมลนี้ถูกใช้แล้ว!',
            text: 'กรุณาใช้อีเมลอื่น',
            icon: 'error',
            timer: 2000, // หน่วงเวลา 3 วินาที
            showConfirmButton: false, // ซ่อนปุ่มยืนยัน
            willClose: () => {
                window.location.href = 'dashboard.php'; 
            }
        });
    </script>";
    } else {
        
        // เพิ่มข้อมูลในฐานข้อมูล
        $sql = "INSERT INTO users (username, email, password, role, status) VALUES ('$user', '$email', '$pass', '$role','$status')";
        if ($conn->query($sql) === TRUE) {
            echo "<<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'เพิ่มสมาชิกสำเร็จ!',
            text: 'สมาชิคถูกเพิ่มลงในฐานข้อมูลแล้ว',
            icon: 'success',
            timer: 2000, // หน่วงเวลา 3 วินาที
            showConfirmButton: false, // ซ่อนปุ่มยืนยัน
            willClose: () => {
                window.location.href = 'dashboard.php'; 
            }
        });
    </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
