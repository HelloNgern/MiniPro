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

if (!isset($_SESSION['id'])) {
    die("Error: User not logged in.");
}

$userId = $_SESSION['id'];

// ตรวจสอบว่ามีการค้นหาหรือไม่
$events = [];
if (isset($_GET['status']) || isset($_GET['term'])) {
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $term = isset($_GET['term']) ? $_GET['term'] : '';

    // ดึงข้อมูลกิจกรรมตามสถานะและคำค้นหา
    $sql = "SELECT id, title, location, details, color, start_time, end_time, liked, share_email, status 
            FROM events 
            WHERE user_id = ? AND (status = ? AND title LIKE ?)";
    $stmt = $conn->prepare($sql);
    $likeTerm = "%" . $conn->real_escape_string($term) . "%"; // ใช้ LIKE เพื่อค้นหาชื่อกิจกรรม
    $stmt->bind_param("iis", $userId, $status, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylee.css"> <!-- ลิงก์ไปยังไฟล์ CSS ของคุณ -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- ลิงก์ FontAwesome -->
    <title>Search Events</title>
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
            <a class="active" href="../search/search.php" ><i class="fa fa-fw fa-search"></i>ค้นหา</a>
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
        <a href="../profile/profile.php">โปรไฟล์</a> <!-- ลิงก์ไปยังหน้า Profile -->
        <a href="../support/support.html">สนับสนุน</a> <!-- ลิงก์ไปยังหน้า Support -->
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

    <div class="wrapper">
        <div class="search-bar">
            <!-- Dropdown สำหรับเลือกสถานะ -->
            <div class="dropdown">
                <div id="drop-text" class="dropdown-text">
                    <span id="span">เลือกสถานะ</span> <!-- ค่าเริ่มต้น -->
                    <i id="icon" class="fa fa-sort-desc"></i>
                </div>
                <ul id="list" class="dropdown-list">
                    <li class="dropdown-list-item" data-status="1">สิ่งที่ต้องทำ</li>
                    <li class="dropdown-list-item" data-status="2">กำลังดำเนินการ</li>
                    <li class="dropdown-list-item" data-status="3">เสร็จสิ้นแล้ว</li>
                </ul>
            </div>

            <!-- กล่องค้นหา -->
            <div class="search-box">
                <input type="text" id="search-input" placeholder="ค้นหาเลย!" />
            </div>
            <button id="search-button">ค้นหา</button>
        </div>

        <div class="results">
            <h3>ผลลัพธ์การค้นหา</h3>
            <ul id="results-list">
                <?php foreach ($events as $event): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                        <p>สถานที่: <?php echo htmlspecialchars($event['location']); ?></p>
                        <p>รายละเอียด: <?php echo htmlspecialchars($event['details']); ?></p>
                        <p>สถานะ: <?php echo htmlspecialchars($event['status']); ?></p>
                        <p>เวลาเริ่ม: <?php echo htmlspecialchars($event['start_time']); ?></p>
                        <p>เวลาสิ้นสุด: <?php echo htmlspecialchars($event['end_time']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script>
        document.getElementById('drop-text').addEventListener('click', function() {
            const dropdownList = document.getElementById('list');
            dropdownList.style.display = dropdownList.style.display === 'block' ? 'none' : 'block';
        });

        // จัดการการเลือกสถานะใน Dropdown
        const dropdownItems = document.querySelectorAll('.dropdown-list-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                document.getElementById('span').textContent = this.textContent;
                dropdownItems.forEach(i => i.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('list').style.display = 'none'; // ซ่อน dropdown หลังจากเลือกสถานะ
            });
        });

        document.getElementById('search-button').addEventListener('click', function() {
            const status = document.querySelector('.dropdown-list-item.selected')?.getAttribute('data-status');
            const searchTerm = document.getElementById('search-input').value;

            // เปลี่ยน URL เพื่อส่งค่าค้นหา
            window.location.href = `search.php?status=${status}&term=${encodeURIComponent(searchTerm)}`;
        });

        // ปิด dropdown เมื่อคลิกนอก dropdown
        window.addEventListener('load', function() {
            // ดึงค่า status จาก URL
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const searchTerm = urlParams.get('term');

            // ถ้ามีสถานะที่เลือกแล้วให้แสดงค่านั้น
            if (status) {
                const savedStatus = document.querySelector(`.dropdown-list-item[data-status='${status}']`);
                if (savedStatus) {
                    document.getElementById('span').textContent = savedStatus.textContent;
                    savedStatus.classList.add('selected');
                }
            } 

            // กรอกคำค้นหาลงในกล่อง search-input ถ้ามี
            if (searchTerm) {
                document.getElementById('search-input').value = decodeURIComponent(searchTerm);
            }
        });
    </script>
<iframe src="../notification/notification.php" style="display:none;"></iframe>
</body>
</html>
