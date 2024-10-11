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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $status=$row['status'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['email'] = $email;
            if($status == '0'){
                header("Location: ../homepage.php"); // เปลี่ยนเส้นทางไปยังหน้า Home
            }else{
                header("Location: ../admin/dashboard.php"); 
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
