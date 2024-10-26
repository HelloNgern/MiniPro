<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การแจ้งเตือนกิจกรรม</title>
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    body{
        overflow-y: scroll;
    }
    </style>
</head>
<body>
    <!-- ส่วนของ Navbar และอื่น ๆ ยังเหมือนเดิม -->
    <?php
    session_start();
    if ($_SESSION['id'] == "") {
       header("Location: ../register/login.html"); // เปลี่ยนเส้นทางไปยังหน้า login.html
       exit();
   }
    ?>

    <!-- ส่วนของ Navbar -->
    <div class="navbar">
        <h2> Remind me! <img src="../register/image/remindd.png" width="40" height="50"></h2>
        <div class="navbar">
            <a href="../home/homepage.php"><i class="fa fa-fw fa-home"></i>หน้าหลัก</a>
            <a href="../calendar/calendar.php"><i class="fa fa fa-calendar"></i> ปฏิทิน</a>
            <a href="../favpage/favpage.php"><i class="fa fas fa-heart"></i> รายการโปรด</a>
            <a class="active" href="../notification/notification.php"><i class="fa fa fa fa-bell"> </i>การแจ้งเตือน</a>
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
    <div class="menu" id="menu"> 
        <a href="../profile/profile.php">โปรไฟล์</a> 
        <a href="../support/support.php">สนับสนุน</a> 
        <a onclick="lockoutUser()" href="#">ออกจากระบบ</a> 
    </div>

    <script>
        function lockoutUser() {
            if (confirm("คุณต้องการล็อกเอาท์ใช่ไหม?")) {
                window.location.href = 'logout.php'; // เปลี่ยนเส้นทางไปยังหน้า logout
            }
        }
        function toggleMenu() {
            var menu = document.getElementById("menu");
            menu.classList.toggle("show");
        }
    </script>

    <!-- คอนเทนเนอร์สำหรับการแจ้งเตือน -->
    <div class="notification-container">
        <h1 class="title">การแจ้งเตือนกิจกรรม</h1>
        <ul id="notification-list" class="list-group">
            <!-- รายการกิจกรรมจะแสดงที่นี่ -->
        </ul>
    </div>

    <!-- เพิ่ม audio สำหรับการแจ้งเตือนด้วยเสียง -->
    <audio id="notify-sound" src="sound/01.mp3" preload="auto"></audio>
    

<script>
    var soundEnabled = false;

    // ฟังก์ชันเปิดใช้งานเสียงแจ้งเตือน
    function enableSound() {
        soundEnabled = true;
        document.getElementById('enable-sound').style.display = 'none'; // ซ่อนปุ่มหลังจากเปิดเสียง
        alert('เสียงแจ้งเตือนเปิดใช้งานแล้ว');
    }
        // ฟังก์ชันสำหรับดึงข้อมูลจาก PHP ทุกๆ 1 วินาที
        function fetchNotifications() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_notifications.php', true);

    xhr.onload = function() {
        if (this.status === 200) {
            var notifications = JSON.parse(this.responseText);
            var notificationList = document.getElementById('notification-list');

            // ล้างข้อมูลเก่า
            notificationList.innerHTML = '';

            // ถ้ามีการแจ้งเตือนกิจกรรม
            if (notifications.length > 0) {
                notifications.forEach(function(notification) {
                    var listItem = document.createElement('li');
                    listItem.className = 'list-group-item list-group-item-warning';
                    listItem.textContent = notification.title + " จะเริ่มในอีก " + notification.remaining + " นาที";
                    
                    // เพิ่ม Event Listener เพื่อให้คลิกที่กิจกรรมแล้วอัปเดตสถานะ
                    listItem.addEventListener('click', function() {
                        updateStatus(notification.id);
                    });

                    notificationList.appendChild(listItem);

                    // ตรวจสอบเวลาแจ้งเตือน
                    if (notification.remaining <= 60 && notification.remaining > 59) {
                        localStorage.setItem('notificationSound', 'true');
                        playNotificationSound(); // แจ้งเตือนเมื่อเหลือ 60 นาที
                    }
                    if (notification.remaining <= 30 && notification.remaining > 29) {
                        localStorage.setItem('notificationSound', 'true');
                        playNotificationSound(); // แจ้งเตือนเมื่อเหลือ 30 นาที
                    }
                });
            } else {
                // ถ้าไม่มีการแจ้งเตือน
                var noNotificationItem = document.createElement('li');
                noNotificationItem.className = 'list-group-item no-notification';
                noNotificationItem.textContent = 'ไม่มีการแจ้งเตือน';
                notificationList.appendChild(noNotificationItem);
            }
        }
    };

    xhr.send();
}
function updateStatus(notificationId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_status.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status === 200) {
            alert('กิจกรรมได้ถูกย้ายไปที่หน้ากำลังดำเนินการแล้ว');
            window.location.href = '../home/doing.php'; // รีเฟรชหน้าหรือไปยังหน้ากำลังดำเนินการ
        } else {
            alert('ไม่สามารถอัปเดตสถานะกิจกรรมได้');
        }
    };  
    
    xhr.send('id=' + notificationId); // ส่งข้อมูล id และ status ใหม่ไปยังเซิร์ฟเวอร์
}



        // ฟังก์ชันสำหรับเล่นเสียงแจ้งเตือน
        function playNotificationSound() {
            var audio = document.getElementById('notify-sound');
            if (audio) {
                audio.play();
            }
        }
        

        // ตรวจสอบ localStorage และเล่นเสียงเมื่อโหลดหน้า
        window.onload = function() {
            if (localStorage.getItem('notificationSound') === 'true') {
                playNotificationSound();
                localStorage.removeItem('notificationSound'); // ลบค่าใน localStorage
            }
        };

        // เรียกใช้ฟังก์ชัน fetchNotifications ทุกๆ 1 วินาที
        setInterval(fetchNotifications, 1000);
    </script>

    <!-- CSS -->
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .notification-container {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        max-width: 600px;
        margin: 50px auto;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .title {
        color: #444;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .list-group-item {
        font-size: 18px;
        margin-bottom: 10px;
        border-radius: 5px;
        padding: 15px;
        background-color: #ffeb99;
        border: 1px solid #ffc107;
        transition: all 0.3s ease;
    }

    .list-group-item-warning:hover {
        background-color: #ffdd75;
    }

    .no-notification {
        background-color: #e9ecef;
        color: #6c757d;
        text-align: center;
    }

    .btn-enable-sound {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }

    .btn-enable-sound:hover {
        background-color: #218838;
    }

    .btn-enable-sound:focus {
        outline: none;
    }
</style>
</body>
</html>
