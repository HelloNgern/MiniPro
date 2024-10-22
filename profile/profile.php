<?php
 session_start();
 if ($_SESSION['id'] == "") {
    header("Location: ../register/login.html"); // เปลี่ยนเส้นทางไปยังหน้า login.html
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
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    .circle-profile {
    width: 150px;
    height: 150px;
    border-radius: 50%; /* ทำให้รูปภาพเป็นวงกลม */
    object-fit: cover; /* ทำให้รูปภาพถูกครอบให้พอดีกับขนาด */
    border: 2px solid #ccc; /* เพิ่มขอบรอบรูป */
    }
   
    </style>
</head>
<body>
<!-- ส่วนของ Navbar -->
<div class="navbar">
        <h2> Remind me! <img src="../register/image/remindd.png" width="40" height="50"></h2>
            
    
        <div class="navbar">
            <a href="../home/homepage.php"><i class="fa fa-fw fa-home"></i>หน้าหลัก</a>
            <a href="../calendar/calendar.php"><i class="fa fa fa-calendar"></i> ปฏิทิน</a>
            <a href="../favpage/favpage.php"><i class="fa fas fa-heart"></i> รายการโปรด</a>
            <a href="#"><i class="fa fa fa fa-bell"> </i>การแจ้งเตือน</a>
            <a href="../search/search.php" ><i class="fa fa-fw fa-search"></i>ค้นหา</a>
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
        <a href="../profile/profile.php">โปรไฟล์</a>
        <a href="../support/support.php">สนับสนุน</a>
        <a onclick="lockoutUser()" href="#">ออกจากระบบ</a> <!-- ลิงก์ไปยังหน้า Logout -->
    </div>
    <script>
        function lockoutUser() {
    if (confirm("คุณต้องการล็อกเอาท์ใช่ไหม?")) {
        window.location.href = '../home/logout.php'; // เปลี่ยนเส้นทางไปยังหน้า logout
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
<iframe src="../notification/notification.php" style="display:none;"></iframe>
</body>
</html>
