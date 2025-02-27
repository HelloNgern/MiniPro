<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- ลิงก์ FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="home.css"> 
    <style>
        .profilee {
    font-size: 1.3em;
    margin-top: -270px; /* ระยะห่างระหว่างภาพและข้อมูล */
    margin-left: 60px; /* ขยับชิดขอบซ้าย 10px */
    color: white;
    font-weight: 600; /* เพิ่มความหนาของฟอนต์ */
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.6); /* เพิ่มเงาให้อ่านง่ายขึ้น */
    letter-spacing: 0.5px; /* เพิ่มระยะห่างระหว่างตัวอักษร */
    line-height: 1.5; /* เพิ่มระยะห่างบรรทัด */
    }
        
    #content-promote {
        padding: 5px; 
        background-size: cover; /* ปรับขนาดรูปให้เต็มพื้นที่ */
        background-position: center; /* จัดรูปให้อยู่ตรงกลาง */
        border-radius: 10px;
        min-height: 200px;
        flex: 1; /* ขยาย content ให้เต็มที่เท่าที่จะทำได้ */
        margin-left: 300px; /* เพิ่มระยะห่างจากขอบซ้าย */
        margin-top: 30px;
    }
    </style>

</head>
<body>
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

$sql = "SELECT profile_pic, username,id ,role FROM users WHERE id = '" . $_SESSION['id'] . "'";
$query = mysqli_query($conn, $sql);
$user = mysqli_fetch_array($query, MYSQLI_ASSOC);
$userId = $_SESSION['id'];
$sql_update_active = "UPDATE users SET status = 'active' WHERE id = '$userId'";
$conn->query($sql_update_active);
$role = $user['role'];
?>
<script>
    // ใช้ JavaScript และ jQuery เพื่ออัปเดตสถานะเป็น inactive เมื่อผู้ใช้ออกจากเว็บไซต์
    window.addEventListener("beforeunload", function () {
        navigator.sendBeacon('update_status_user.php', JSON.stringify({status: 'inactive', userId: <?php echo $userId; ?>}));
    });


</script>
    <!-- ส่วนของ Navbar -->
    <div class="navbar">
        <h2> Remind me! <img src="../register/image/remindd.png" width="40" height="50"></h2>
            
    
        <div class="navbar-item">
            
            <a class="active" href="homepage.php"><i class="fa fa-fw fa-home"></i>หน้าหลัก</a>
            <a href="../calendar/calendar.php"><i class="fa fa fa-calendar"></i> ปฏิทิน</a>
            <a href="../favpage/favpage.php"><i class="fa fas fa-heart"></i> รายการโปรด</a>
            <a href="../notification/notification.php"><i class="fa fa fa fa-bell"> </i>การแจ้งเตือน</a>
            <a href="../search/search.php" ><i class="fa fa-fw fa-search"></i>ค้นหา</a>

        </div>
       
    
        <!-- ปุ่ม Hamburger -->
        <div class="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        
    </div>
    
    <!-- เมนูที่ซ่อนอยู่ -->
    <div class="menu" id="menu"> <!-- เมนูที่ถูกซ่อนอยู่ มี id="menu" เพื่อให้เรียกใช้ได้ง่าย -->
        <a href="../profile/profile.php">โปรไฟล์</a> <!-- ลิงก์ไปยังหน้า Profile -->
        <a href="../support/support.php">สนับสนุน</a> <!-- ลิงก์ไปยังหน้า Support -->
        <a onclick="lockoutUser()" href="#">ออกจากระบบ</a> <!-- ลิงก์ไปยังหน้า Logout -->
        <a id="adminButton" style="display: none;" onclick="goToDashboard()">Admind dashboard</a>
    </div>
    <script>
        const role = "<?php echo $role; ?>";
        
        // ถ้า role เป็น 'admin' ให้แสดงปุ่มที่ซ่อนอยู่
        if (role === "1") {
            document.getElementById("adminButton").style.display = "block";
        }

        // ฟังก์ชันเปลี่ยนหน้าไปที่ Dashboard
        function goToDashboard() {
            window.location.href = "../admin/dashboard.php"; // กำหนด URL ของหน้า Dashboard ที่ต้องการ
        }
    </script>
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

    <div class="main-content">
    <div class="profile">
        <!-- รูปโปรไฟล์จะแสดงที่นี่ -->
        <div class="profile-pic">
           
            <img src="../uploads/<?php echo $user['profile_pic']; ?>" alt="Profile Picture" class="circle-profile">
        </div>
    </div>
    <div id="content-promote" ><img src="../register/image/promote.png" width="900" height="320" ></div>
    </div>

    <div>
        <h2 class="move-down" >งานของฉัน</h2>
    </div>


    <div>
        <div class="container">
            <!-- กล่องที่ 1: สำหรับ "สิ่งที่ต้องทำ" -->
            <div class="box" onclick="window.location.href='todo.php'">
                <img src="../register/image/remindd.png" alt="สิ่งที่ต้องทำ"> <!-- ไอคอนรูปภาพ -->
                <p>สิ่งที่ต้องทำ!</p> <!-- ข้อความในกล่อง -->
            </div>

            <!-- กล่องที่ 2: สำหรับ "กำลังดำเนินการ" -->
            <div class="box student" onclick="window.location.href='doing.php'">
                <img src="../register/image/remindd.png" alt="กำลังดำเนินการ"> <!-- ไอคอนรูปภาพ -->
                <p>กำลังดำเนินการ...</p> <!-- ข้อความในกล่อง -->
            </div>
    
            <!-- กล่องที่ 3: สำหรับ "เสร็จสิ้นแล้ว" -->
            <div class="box research" onclick="window.location.href='succeed.php'">
                <img src="../register/image/remindd.png" alt="เสร็จสิ้นแล้ว"> <!-- ไอคอนรูปภาพ -->
                <p>เสร็จสิ้นแล้ว</p> <!-- ข้อความในกล่อง -->
            </div>
        </div>
    </div>
    
    <!-- ข้อมูลผู้ใช้จะแสดงที่นี่ -->
    <div class="profilee">
        <span>Username:</span>
        <span><?php echo $user['username']; ?></span><br>
        <span>Id:</span>
        <span><?php echo $user['id']; ?></span>
    </div>
    <script>
        // ตัวอย่างข้อมูลผู้ใช้ที่สามารถดึงมาจาก backend
        const user = {
            id: '12345',
            name: 'John Doe',
            profileImage: 'https://via.placeholder.com/100' // ลิงก์ไปยังรูปโปรไฟล์ของผู้ใช้
        };

        // อัปเดตรูปโปรไฟล์และข้อมูลผู้ใช้ใน HTML
        document.getElementById('profile-image').src = user.profileImage;
        document.getElementById('username').textContent = `Username: ${user.name}`;
        document.getElementById('user-id').textContent = `User ID: ${user.id}`;


        function toggleHeart() {
            var likeEvent = document.getElementById("likeEvent");
            var likeIcon = document.getElementById("likeIcon");

            if (likeEvent.value == "0") {
                // เมื่อกดหัวใจ เปลี่ยนเป็นชื่นชอบ
                likeEvent.value = "1";
                likeIcon.classList.remove("fa-heart-o"); // ไอคอนหัวใจว่างเปล่า
                likeIcon.classList.add("fa-heart"); // เปลี่ยนเป็นไอคอนหัวใจเต็ม
            } else {
                // หากกดอีกครั้ง เปลี่ยนกลับเป็นไม่ชื่นชอบ
                likeEvent.value = "0";
                likeIcon.classList.remove("fa-heart"); // ไอคอนหัวใจเต็ม
                likeIcon.classList.add("fa-heart-o"); // เปลี่ยนเป็นไอคอนหัวใจว่างเปล่า
            }
        }
    </script>

    <!--script ปฏิทิน-->
    <script src="calendar/calendar.js">
        
    </script>

   
<!-- ปุ่มวงกลมสำหรับเพิ่ม Event -->
<button id="addEventButton" class="add-event-btn">
    <i class="fa fa-plus"></i>
</button>
<!-- ฟอร์มสำหรับเพิ่ม Event -->
<div id="eventForm" class="event-form">
    <h3>เพิ่ม Event ใหม่</h3>
    <form id="newEventForm" action="save_event.php" method="POST">
        <table>
            <tr>
                <td>
                    <div class="form-group">
                        <label for="eventTitle">ชื่อหัวข้อ:</label>
                        <input type="text" id="eventTitle" name="eventTitle" placeholder="กรอกชื่อหัวข้อ" required>
                    </div>

                    <div class="form-group">
                        <label for="eventLocation">สถานที่:</label>
                        <input type="text" id="eventLocation" name="eventLocation" placeholder="กรอกสถานที่" required>
                    </div>

                    <div class="form-group">
                        <label for="eventDetails">รายละเอียดกิจกรรม:</label>
                        <textarea id="eventDetails" name="eventDetails" placeholder="กรอกรายละเอียดกิจกรรม" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="eventColor">เลือกสี:</label>
                        <div class="color-container">
                        <input type="color" id="eventColor" name="eventColor" required>

                        <input type="hidden" id="likeEvent" name="likeEvent" value="0">
                        <i id="likeIcon" class="fa fa-heart-o heart-icon" onclick="toggleHeart()"></i>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label for="eventStart">วันที่เริ่ม:</label>
                        <input type="datetime-local" id="eventStart" name="eventStart" required>
                    </div>

                    <div class="form-group">
                        <label for="eventEnd">วันที่สิ้นสุด:</label>
                        <input type="datetime-local" id="eventEnd" name="eventEnd" required>
                    </div>

                    <div class="form-group">
                        <label for="shareEmail">แชร์ทางอีเมล:</label>
                        <input type="email" id="shareEmail" name="shareEmail" placeholder="example@example.com">
                    </div>
                    <br><br><br><br>
                    
                    <div class="form-group"></div>
                    <button type="submit">บันทึกกิจกรรม</button>
                    </div>
                    <br><br>
                </td>
            </tr>
        </table>
    </form>
    </div>
    <iframe src="../notification/notification.php" style="display:none;"></iframe>
<script src="home.js"></script>
</body>
</html>
