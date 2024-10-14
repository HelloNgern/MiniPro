<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// หลังจากตรวจสอบความถูกต้องของข้อมูลผู้ใช้
// $userId คือ ID ของผู้ใช้ที่ล็อกอิน

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email='$email' ";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role=$row['role'];
      
        if (password_verify($pass, $row['password'])) {
            $_SESSION['id'] = $row['id']; 
            if($role == '0'){
                header("Location: ../home/homepage.php"); // เปลี่ยนเส้นทางไปยังหน้า Home
            }else{
                header("Location: ../admin/showdata.php");
            }
           
            exit(); // จบการทำงานของสคริปต์
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบบัญชีผู้ใช้";
    }
}

$conn->close();
?>
