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
    $check_query = "SELECT * FROM users WHERE username='$user' OR email='$email'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้แล้ว";
    } else {
        // เพิ่มข้อมูลในฐานข้อมูล
        $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$pass')";
        if ($conn->query($sql) === TRUE) {
            echo "สมัครสมาชิกสำเร็จ!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
