<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="home.css"> 
</head>
<body bgcolor="#1D0066">
    <?php
    session_start();
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id']; // ดึง user_id จาก session
    } else {
        echo "กรุณาล็อกอินก่อนใช้งาน";
    }
    ?>
    <!-- ส่วนของ Navbar -->
    <div class="navbar">
        <h2> Remind me! <img src="../register/image/remindd.png" width="40" height="50"></h2>
            
    
        <div class="navbar">
            <a class="active" href="#" onclick="loadContent('home.html')"><i class="fa fa-fw fa-home"></i>หน้าหลัก</a>
            <a href="calendar/calendar.html" onclick="loadContent('calendar01.html')"><i class="fa fa fa-calendar"></i> ปฏิทิน</a>
            <a href="#" onclick="loadContent('favorites.html')"><i class="fa fa fa-bookmark"></i> รายการโปรด</a>
            <a href="#" onclick="loadContent('HomepageMP3.html')"><i class="fa fa fa fa-bell"> </i>การแจ้งเตือน</a>
            <a href="#"><i class="fa fa-fw fa-search"></i> Search</a>
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
        <a href="#">Profile</a> <!-- ลิงก์ไปยังหน้า Profile -->
        <a href="#">Settings</a> <!-- ลิงก์ไปยังหน้า Settings -->
        <a href="#">Logout</a> <!-- ลิงก์ไปยังหน้า Logout -->
    </div>
    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu"); // เข้าถึงเมนูด้วย id="menu"
            menu.classList.toggle("show"); // สลับการเพิ่ม/ลบ class "show" เพื่อแสดงหรือซ่อนเมนู
        }
    </script>   

    <div class="main-content">
    <div class="profile">
        <!-- รูปโปรไฟล์จะแสดงที่นี่ -->
        <img id="profile-image" src="" alt="Profile Image">

        <!-- ข้อมูลผู้ใช้จะแสดงที่นี่ -->
        <div class="profile-info">
            <p id="username">Username: </p>
            <p id="user-id">User ID: </p>
        </div>
    </div>
    <div id="content">
    <h2>ยินดีต้อนรับสู่หน้าแรก</h2>
    <p>นี่คือเนื้อหาหน้าแรก</p>
    </div>
    </div>

    <script>
        function loadContent(filename) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', filename, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('content').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>

    <div>
        <h2 class="move-down" >งานของฉัน</h2>
    </div>


    <div>
        <div class="container">
            <!-- กล่องที่ 1: สำหรับ "สิ่งที่ต้องทำ" -->
            <div class="box" onclick="window.location.href='สิ่งที่ต้องทำ.html'">
                <img src="register/image/remindd.png" alt="สิ่งที่ต้องทำ"> <!-- ไอคอนรูปภาพ -->
                <p>สิ่งที่ต้องทำ!</p> <!-- ข้อความในกล่อง -->
            </div>

            <!-- กล่องที่ 2: สำหรับ "กำลังดำเนินการ" -->
            <div class="box student" onclick="window.location.href='กำลังดำเนินการ.html'">
                <img src="register/image/remindd.png" alt="กำลังดำเนินการ"> <!-- ไอคอนรูปภาพ -->
                <p>กำลังดำเนินการ...</p> <!-- ข้อความในกล่อง -->
            </div>
    
            <!-- กล่องที่ 3: สำหรับ "เสร็จสิ้นแล้ว" -->
            <div class="box research" onclick="window.location.href='เสร็จสิ้นแล้ว.html'">
                <img src="register/image/remindd.png" alt="เสร็จสิ้นแล้ว"> <!-- ไอคอนรูปภาพ -->
                <p>เสร็จสิ้นแล้ว</p> <!-- ข้อความในกล่อง -->
            </div>
        </div>
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



<script src="home.js"></script>
</body>
</html>
</body>
</html>
