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

$sql = "SELECT * FROM users WHERE id = '" . $_SESSION['id'] . "'";
$query = mysqli_query($conn, $sql);
$user = mysqli_fetch_array($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profilead.css">
    <title>Profile Page</title>
</head>
<body>

 <!-- Sidebar -->
 <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="showdata.php">Dashboard</a></li>
            <li><a href="dashboard.php">Users Management</a></li>
            <li><a href="">Profile Admin</a></li>
            
        </ul>
    </div>

<div class="row">
    <!-- ข้อมูลปัจจุบันของผู้ใช้ -->
    <div class="col-md-6 profile-info">
        <h4>ข้อมูลปัจจุบันของคุณ</h4>
        <div class="info-row">
            <strong>UserID:</strong>
            <span><?php echo $user['id']; ?></span>
        </div>
        <div class="info-row">
            <strong>Username :</strong>
            <span><?php echo $user['username']; ?></span>
        </div>
        <div class="info-row">
            <strong>Email :</strong>
            <span><?php echo $user['email']; ?></span>
        </div>
        <div class="info-row">
            <strong>Password :</strong>
            <span>********</span> <!-- ซ่อนรหัสผ่านด้วยการแสดง ******** -->
        </div>
        <div class="info-row">
            <strong>Role :</strong>
            <span><?php echo $user['role']; ?></span>
        </div>
        
        <!-- ปุ่มโยงไปยังหน้า edit -->
        <button onclick="location.href='editpro.php'">แก้ไขโปรไฟล์</button>
    </div>
</div>

</body>
</html>
