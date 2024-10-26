<?php
 session_start();
 if ($_SESSION['id'] == "" || $_SESSION['role'] != "1") {
    header("Location: ../register/login.html"); // เปลี่ยนเส้นทางไปยังหน้า login.html หรือหน้าอื่นๆ เช่นหน้าแจ้งเตือน
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
    <style>
    .circle-profile {
    width: 150px;
    height: 150px;
    border-radius: 50%; /* ทำให้รูปภาพเป็นวงกลม */
    object-fit: cover; /* ทำให้รูปภาพถูกครอบให้พอดีกับขนาด */
    border: 2px solid #ccc; /* เพิ่มขอบรอบรูป */
    }
    /* จัดตำแหน่งให้ span อยู่กลาง */
    .profile-info .info-row span {
        flex-grow: 1; /* ทำให้ span เติบโตเต็มที่ */
        text-align: left; /* จัดตำแหน่งข้อความให้ตรงกลาง */
    }
   
    </style>
</head>
<body>

 <!-- Sidebar -->
 <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="showdata.php">Dashboard</a></li>
            <li><a href="dashboard.php">Users Management</a></li>
            <li><a href="">Profile Admin</a></li>
            <li><a href="../home/homepage.php">Check Design</a></li>
            <li><a onclick="lockoutUser()" href="#">Logout</a><li>  
        </ul>
    </div>
    <script>
    function lockoutUser() {
        if (confirm("คุณต้องการล็อกเอาท์ใช่ไหม?")) {
            window.location.href = '../home/logout.php'; 
        }
    }
    </script>

<div class="row">
    <!-- ข้อมูลปัจจุบันของผู้ใช้ -->
    <div class="col-md-6 profile-info">
        <h4>ข้อมูลปัจจุบันของคุณ</h4>
        <div class="profile-pic">
           
            <img src="../uploads/<?php echo $user['profile_pic']; ?>" alt="Profile Picture" class="circle-profile">
        </div>
        <div class="info-row">
            <strong>UserID:</strong>
            <span><?php echo $user['id']; ?></span>
        </div>
        <div class="info-row">
            <strong>Username:</strong>
            <span><?php echo $user['username']; ?></span>
        </div>
        <div class="info-row">
            <strong>Email:</strong>
            <span><?php echo $user['email']; ?></span>
        </div>
        <div class="info-row">
            <strong>Password:</strong>
            <span>********</span> <!-- ซ่อนรหัสผ่านด้วยการแสดง ******** -->
        </div>
     
        
        <!-- ปุ่มโยงไปยังหน้า edit -->
        <button onclick="location.href='editpro.php'">แก้ไขข้อมูลส่วนตัว</button>
    </div>
</div>

</body>
</html>
