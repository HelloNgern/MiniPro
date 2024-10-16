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
    <title>Profile Page</title>
    <link rel="stylesheet" href="../home/home.css">
</head>
<body>
<!-- ส่วนของ Navbar -->
<div class="navbar">
        <h2> Remind me! <img src="../register/image/remindd.png" width="40" height="50"></h2>
            
    
        <div class="navbar">
            <a class="active" href="homepage.php"><i class="fa fa-fw fa-home"></i>หน้าหลัก</a>
            <a href="../calendar/calendar.html"><i class="fa fa fa-calendar"></i> ปฏิทิน</a>
            <a href="../favpage/favpage.html"><i class="fa fas fa-heart"></i> รายการโปรด</a>
            <a href="#"><i class="fa fa fa fa-bell"> </i>การแจ้งเตือน</a>
            <a href="../search/search.html" ><i class="fa fa-fw fa-search"></i>ค้นหา</a>
        </div>
       
    
        <!-- ปุ่ม Hamburger -->
        <div class="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        
    </div>
    
    <!-- เมนูที่ซ่อนอยู่ -->
    <div class="menu" id="menu"> <!-- เมนูที่ถูกซ่อนอยู่ มี id="menu" เพื่อให้เรียกใช้ได้ง่าย -->
        <a href="../profile/profile.php">Profile</a> <!-- ลิงก์ไปยังหน้า Profile -->
        <a href="#">Settings</a> <!-- ลิงก์ไปยังหน้า Settings -->
        <a onclick="lockoutUser()" href="#">Logout</a> <!-- ลิงก์ไปยังหน้า Logout -->
    </div>
    <script>
        function lockoutUser() {
    if (confirm("คุณต้องการล็อกเอาท์ใช่ไหม?")) {
        window.location.href = 'logout.php'; // เปลี่ยนเส้นทางไปยังหน้า logout
    }
}
        function toggleMenu() {
            var menu = document.getElementById("menu"); // เข้าถึงเมนูด้วย id="menu"
            menu.classList.toggle("show"); // สลับการเพิ่ม/ลบ class "show" เพื่อแสดงหรือซ่อนเมนู
        }
    </script>

<div class="row">
    <!-- ข้อมูลปัจจุบันของผู้ใช้ -->
    <div class="col-md-6 profile-info">
        <h4>ข้อมูลปัจจุบันของคุณ</h4><br>
        <p><strong>UserID:</strong> <?php echo $user['id']; ?></p>
        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Password:</strong> ********</p> <!-- ซ่อนรหัสผ่านด้วยการแสดง ******** -->
        <p><strong>Role:</strong> <?php echo $user['role']; ?></p>
        
        <!-- ปุ่มโยงไปยังหน้า update -->
        <button onclick="location.href='updatepro.php'" style="margin-top: 20px;">Update Profile</button>
    </div>
</div>
</body>
</html>
