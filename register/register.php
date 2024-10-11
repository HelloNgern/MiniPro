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
            timer: 3000, // หน่วงเวลา 3 วินาที
            showConfirmButton: false, // ซ่อนปุ่มยืนยัน
            willClose: () => {
                window.location.href = 'signup.html'; // เปลี่ยนเส้นทางไปยังหน้า login เมื่อแจ้งเตือนปิดลง
            }
        });
    </script>";
    } else {
        // เพิ่มข้อมูลในฐานข้อมูล
        $sql = "INSERT INTO users (username, email, password, status) VALUES ('$user', '$email', '$pass', '0')";
        if ($conn->query($sql) === TRUE) {
            echo "<<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'สมัครสมาชิกสำเร็จ!',
            text: 'คุณจะถูกเปลี่ยนไปยังหน้าล็อกอินในไม่ช้า',
            icon: 'success',
            timer: 3000, // หน่วงเวลา 3 วินาที
            showConfirmButton: false, // ซ่อนปุ่มยืนยัน
            willClose: () => {
                window.location.href = 'login.html'; // เปลี่ยนเส้นทางไปยังหน้า login เมื่อแจ้งเตือนปิดลง
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
