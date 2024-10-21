<?php
session_start();
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['id']; // สมมติว่าคุณเก็บ user_id ใน session

// ตรวจสอบว่ามีกิจกรรมในฐานข้อมูลหรือไม่
$sql = "SELECT * FROM events WHERE user_id = '$userId' ORDER BY start_time DESC";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    // ดึงข้อมูลกิจกรรมทั้งหมด
    while ($row = $result->fetch_assoc()) {
        $eventDate = date('Y-m-d', strtotime($row['start_time'])); // เปลี่ยนรูปแบบวันให้ตรง
        $events[$eventDate][] = $row; // จัดเก็บกิจกรรมตามวันที่
    }
}

// ปิดการเชื่อมต่อ
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="calendar.css">
    <title>Calendar</title>
    <style>
      
    .calendar {
        
        width: 80%;
        max-width: 600px;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr; /* 2 คอลัมน์ โดยแต่ละคอลัมน์มีขนาดเท่ากัน */
    
    gap: 100px; /* ระยะห่างระหว่างคอลัมน์ */
    padding: 100px;
}

.grid-item {
    background-color: #76c7c0;
    padding: 20px;
    text-align: center;
    border: 2px solid #333;
    font-size: 20px;
}
.grid-item1 {
    margin-left: 100px;
    width: 80%;
        max-width: 400px;
        background-color: white;
     
        
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    color: black;
    font-family: 'Poppins', sans-serif; /* ใช้ฟอนต์ Poppins จาก Google Fonts */
    font-size: 16px; /* ขนาดฟอนต์ */
    line-height: 1.6; /* เพิ่มระยะห่างบรรทัดเพื่อให้อ่านง่าย */
}


.nav-button:hover {
    background-color: #59a69e; /* เปลี่ยนสีพื้นหลังของปุ่มเมื่อ hover */
}

.month-year {
    font-size: 30px; /* กำหนดขนาดตัวอักษร */
    font-weight: bold; /* ทำให้ตัวอักษรหนา */
    color: #333; /* กำหนดสีของตัวอักษรเป็นสีเทาเข้ม */
    cursor: pointer; /* เปลี่ยนเคอร์เซอร์เมื่อเลื่อนเมาส์ */
}

.calendar-grid {
    display: grid; /* ใช้ grid layout เพื่อจัดการกริดของปฏิทิน */
    grid-template-columns: repeat(7, 1fr); /* สร้าง 7 คอลัมน์ที่มีขนาดเท่ากัน */
    gap: 10px; /* เพิ่มช่องว่างระหว่างกริด */
}

.day-name {
    text-align: center; /* จัดข้อความให้อยู่กลาง */
    font-weight: bold; /* ทำให้ตัวอักษรหนา */
    color: black; /* กำหนดสีตัวอักษรเป็นสีเทาเข้ม */
    font-size: 18px; /* กำหนดขนาดตัวอักษร */
    background-color:#E8A44B;
    border-radius:8px;
}

.day {
    background-color:#FFF8DC; /* กำหนดสีพื้นหลังของแต่ละวัน */
    padding: 15px; /* เพิ่มช่องว่างในแต่ละวัน */
    text-align: center; /* จัดข้อความให้อยู่กลาง */
    border-radius: 5px; /* ทำให้ขอบมีความโค้งมน */
    font-size: 16px; /* กำหนดขนาดตัวอักษร */
    color: #333; /* กำหนดสีตัวอักษรเป็นสีเทาเข้ม */
    cursor: pointer; /* เปลี่ยนเคอร์เซอร์เมื่อเลื่อนเมาส์ */
    transition: background-color 0.3s ease; /* เพิ่มเอฟเฟกต์เปลี่ยนสีพื้นหลังเมื่อ hover */
}

.current-day {
    background-color: rgb(247, 168, 21); /* กำหนดสีพื้นหลังสำหรับวันที่ปัจจุบัน */
    border-radius: 50%;
}


.event-detail {
    background-color: #f9f9f9; /* กำหนดพื้นหลังของกล่องรายละเอียดเหตุการณ์ */
    padding: 15px; /* เพิ่มช่องว่างภายในกล่อง */
    margin-bottom: 10px; /* เพิ่มระยะห่างด้านล่าง */
    border-radius: 5px; /* ทำให้ขอบมีความโค้งมน */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* เพิ่มเงาเล็กน้อย */
}

.event-detail strong {
    font-size: 18px; /* กำหนดขนาดตัวอักษร */
    color: #333; /* กำหนดสีตัวอักษรเป็นสีเทาเข้ม */
}

.no-event-message {
    font-size: 16px; /* กำหนดขนาดตัวอักษรสำหรับข้อความไม่มีเหตุการณ์ */
    color: #666; /* กำหนดสีตัวอักษรเป็นสีเทาอ่อน */
}

#eventDetailsContainer {
    background-color: #E8A44B; /* กำหนดพื้นหลังเป็นสีขาว */
    padding: 20px; /* เพิ่มช่องว่างภายใน */
    border-radius: 10px; /* ทำให้ขอบมีความโค้งมน */
    box-shadow: 0 0 10px rgba(15, 6, 6, 0.018); /* เพิ่มเงารอบกล่อง */
}


#yearList div:hover {
    background-color: #4CAF50; /* เปลี่ยนสีพื้นหลังเมื่อ hover */
    color: white; /* เปลี่ยนสีตัวอักษรเมื่อ hover */
}


    </style>
</head>
<body bgcolor="#1D0066">
    <!-- ส่วนของ Navbar -->
<div class="navbar">
        <h2> Remind me! <img src="../register/image/remindd.png" width="40" height="50"></h2>
            
    
        <div class="navbar">
            <a href="../home/homepage.php"><i class="fa fa-fw fa-home"></i>หน้าหลัก</a>
            <a class="active" href="../calendar/calendar.php"><i class="fa fa fa-calendar"></i> ปฏิทิน</a>
            <a href="../favpage/favpage.php"><i class="fa fas fa-heart"></i> รายการโปรด</a>
            <a href="../notification/notification.php"><i class="fa fa fa fa-bell"> </i>การแจ้งเตือน</a>
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
        <a href="../support/support.html">สนับสนุน</a>
        <a onclick="lockoutUser()" href="#">ออกจากระบบ</a> <!-- ลิงก์ไปยังหน้า Logout -->
    </div>
    <script>
    function lockoutUser() {
        if (confirm("คุณต้องการล็อกเอาท์ใช่ไหม?")) {
            window.location.href = '../home/logout.php'; 
        }
    }
</script>

    <script>
        const events = <?php echo json_encode($events); ?>; // ส่งข้อมูลกิจกรรมไปยัง JavaScript

        function displayEvents() {
            const daysContainer = document.getElementById('daysContainer');
            const days = daysContainer.getElementsByClassName('day');

            // วนลูปผ่านวันในปฏิทิน
            for (let day of days) {
                const date = day.getAttribute('data-date'); // ดึงวันที่จาก data-date
                const dayNumber = new Date(date).getDate(); // ดึงเลขวันที่
                day.innerHTML = dayNumber; // แสดงเลขวันที่

                // ตรวจสอบว่ามีกิจกรรมสำหรับวันที่นี้หรือไม่
                if (events[date]) {
               
                    day.innerHTML += `<span class="bi bi-pin-fill" style="color: red;"></span>`; // ทำเครื่องหมายวันที่ด้วยดอกจันสีแดง
                    day.onclick = function() {
                        showEventDetails(events[date]); // เรียกฟังก์ชันเพื่อแสดงรายละเอียดกิจกรรม
                    };
                } else {
                    day.onclick = function() {
                        showEventDetails([]); // ส่ง array ว่างเมื่อคลิกวันที่ไม่มีการจัดกิจกรรม
                    };
                }
            }
        }


        let currentlyDisplayedEvents = null; // ตัวแปรเพื่อเก็บสถานะกิจกรรมที่แสดงอยู่
        let currentlyHighlightedDay = null; // ตัวแปรเพื่อเก็บวันที่ที่ถูกไฮไลต์

        function showEventDetails(eventsForDate) {
            const eventDetailsContainer = document.getElementById('eventDetailsContainer');
            eventDetailsContainer.innerHTML = ''; // เคลียร์เนื้อหาก่อน

            // ตรวจสอบว่ากิจกรรมที่คลิกซ้ำคือกิจกรรมเดียวกันหรือไม่
            if (currentlyDisplayedEvents === eventsForDate) {
                // ถ้าเป็นกิจกรรมเดียวกัน ให้ซ่อนรายละเอียด
                closeEventDetails();
                currentlyDisplayedEvents = null; // ตั้งค่าสถานะกลับเป็น null
                clearHighlightedDay(); // เคลียร์การไฮไลต์วันก่อนหน้า
                return; // ออกจากฟังก์ชัน
            }

            // เคลียร์การไฮไลต์วันก่อนหน้า
            clearHighlightedDay();

            // ตรวจสอบว่ามีกิจกรรมสำหรับวันที่นี้หรือไม่
            if (eventsForDate && eventsForDate.length > 0) {
                // ถ้ามีกิจกรรมให้แสดงรายละเอียด
                eventsForDate.forEach(event => {
                    const eventElement = document.createElement('div');
                    eventElement.className = 'event-detail';
                    eventElement.innerHTML = `<strong>${event.title}</strong><br>สถานที่: ${event.location}<br>รายละเอียด: ${event.details}<br>เวลาเริ่ม: ${event.start_time}<br>เวลาสิ้นสุด: ${event.end_time}<br></div>`;
                    eventDetailsContainer.appendChild(eventElement);
                });
                eventDetailsContainer.style.display = 'block'; // แสดงรายละเอียดใน UI

                // ไฮไลต์วันที่ถูกคลิก
                currentlyHighlightedDay = document.querySelector(`.day[data-date="${eventsForDate[0].date}"]`);
                if (currentlyHighlightedDay) {
                    currentlyHighlightedDay.classList.add('highlighted-day'); // เพิ่มคลาสเพื่อเปลี่ยนพื้นหลัง
                }
            } else {
                // ถ้าไม่มี ให้แสดงข้อความว่าไม่มีการจัดกิจกรรม
                const noEventMessage = document.createElement('div');
                noEventMessage.className = 'no-event-message';
                noEventMessage.innerHTML = 'ไม่มีการจัดกิจกรรมในวันที่เลือก';
                eventDetailsContainer.appendChild(noEventMessage);
                eventDetailsContainer.style.display = 'block'; // แสดงข้อความ
            }

            currentlyDisplayedEvents = eventsForDate; // อัปเดตสถานะที่แสดงอยู่
        }

        // ฟังก์ชันเพื่อเคลียร์การไฮไลต์วัน
        function clearHighlightedDay() {
            if (currentlyHighlightedDay) {
                currentlyHighlightedDay.classList.remove('highlighted-day'); // ลบคลาสที่ใช้เพื่อไฮไลต์
                currentlyHighlightedDay = null; // รีเซ็ตตัวแปร
            }
        }

        // ปิดการแสดงรายละเอียดกิจกรรม
        function closeEventDetails() {
            const eventDetailsContainer = document.getElementById('eventDetailsContainer');
            eventDetailsContainer.style.display = 'none';
        }
        let currentMonth = new Date().getMonth(); // เดือนปัจจุบัน
        let currentYear = new Date().getFullYear(); // ปีปัจจุบัน

        function nextMonth() {
            // ถ้าหากเดือนคือ ธันวาคม (11) ให้เปลี่ยนไปมกราคม (0) ของปีถัดไป
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            updateCalendar(); // อัปเดตปฏิทิน
        }

        function prevMonth() {
            // ถ้าหากเดือนคือ มกราคม (0) ให้เปลี่ยนไปธันวาคม (11) ของปีที่ผ่านมา
            if (currentMonth === 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }
            updateCalendar(); // อัปเดตปฏิทิน
        }

        function updateCalendar() {
            const daysContainer = document.getElementById('daysContainer');
            daysContainer.innerHTML = ''; // เคลียร์วันที่เดิม

            const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
            const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
            const today = new Date(); // วันที่ปัจจุบัน

            // คำนวณวันแรกของเดือน (วันในสัปดาห์)
            const firstDayOfWeek = firstDayOfMonth.getDay();

            // สร้างช่องว่างสำหรับวันในเดือนก่อนหน้า
            for (let i = 0; i < firstDayOfWeek; i++) {
                const emptyDayDiv = document.createElement('div');
                daysContainer.appendChild(emptyDayDiv); // เพิ่ม div ว่างเพื่อการจัดระเบียบ
            }

            // สร้างวันที่ในเดือนปัจจุบัน
            for (let day = 1; day <= lastDayOfMonth.getDate(); day++) {
                const dateString = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayDiv = document.createElement('div');
                dayDiv.className = 'day';
                dayDiv.setAttribute('data-date', dateString);
                dayDiv.innerHTML = day;

                // ตรวจสอบว่ามันคือวันที่ปัจจุบันหรือไม่
                if (today.getFullYear() === currentYear && today.getMonth() === currentMonth && today.getDate() === day) {
                    dayDiv.classList.add('current-day'); // เพิ่มคลาสเพื่อไฮไลต์วันที่ปัจจุบัน
                }

                // ตรวจสอบว่ามีกิจกรรมสำหรับวันที่นี้หรือไม่
                if (events[dateString]) {
                    dayDiv.innerHTML += `<span class="bi bi-pin-fill red-icon" style="color: red;"></span>`;
                    dayDiv.onclick = function() {
                        showEventDetails(events[dateString]);
                    };
                }

                daysContainer.appendChild(dayDiv); // เพิ่มวันลงในปฏิทิน
            }

            // อัปเดตชื่อเดือนและปี
            document.getElementById('monthName').textContent = firstDayOfMonth.toLocaleString('default', { month: 'long' });
            document.getElementById('yearDisplay').textContent = currentYear;
        }


        // เรียกใช้เพื่อแสดงปฏิทินเมื่อโหลดหน้า
        window.onload = function() {
            updateCalendar();
        };

        function openYearPopup() {
            document.getElementById('yearPopup').style.display = 'block';
            generateYearList();
        }

        function closeYearPopup() {
            document.getElementById('yearPopup').style.display = 'none';
        }

        function generateYearList() {
            const yearListDiv = document.getElementById('yearList');
            yearListDiv.innerHTML = '';

            for (let i = 2000; i <= 2050; i++) {
                const yearDiv = document.createElement('div');
                yearDiv.textContent = i;
                yearDiv.onclick = function() {
                    changeYear(i);
                };
                yearListDiv.appendChild(yearDiv);
            }
        }

        function changeYear(selectedYear) {
            currentYear = selectedYear; // เปลี่ยนปี
            closeYearPopup(); // ปิดป๊อปอัพ
            updateCalendar(); // อัปเดตปฏิทินเพื่อแสดงวันที่ใหม่
        }

        function toggleMenu() {
            var menu = document.getElementById("menu");
            menu.classList.toggle("show");
        }
    </script>

    <div class="main-content" class="grid-container">
        <div class="calendar" class="grid-item">
            <div class="calendar-header">
                <button class="nav-button" onclick="prevMonth()">❮</button>
                <div class="month-year">
                    <span id="monthName"></span>
                    <span id="yearDisplay" class="month-year" onclick="openYearPopup()"></span>
                </div>
                <button class="nav-button" onclick="nextMonth()">❯</button>
            </div>

            <div class="calendar-grid">
                <div class="day-name">Sun</div>
                <div class="day-name">Mon</div>
                <div class="day-name">Tue</div>
                <div class="day-name">Wed</div>
                <div class="day-name">Thu</div>
                <div class="day-name">Fri</div>
                <div class="day-name">Sat</div>
            </div>

            <div class="calendar-grid" id="daysContainer">
                <?php
                // กำหนดเดือนและปีที่ต้องการสร้างปฏิทิน
                // ใช้เดือนและปีจากการส่งค่า GET ถ้ามี ไม่เช่นนั้นให้ใช้เดือนและปีปัจจุบัน
                $month = date('n'); // เดือนปัจจุบัน
                $year = date('Y'); // ปีปัจจุบัน

                if (isset($_GET['month']) && isset($_GET['year'])) {
                    $month = (int)$_GET['month'];
                    $year = (int)$_GET['year'];
                }

                // หาจำนวนวันที่ในเดือน
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                for ($day = 1; $day <= $daysInMonth; $day++) {
                    // สร้างวันที่ในรูปแบบ YYYY-MM-DD
                    $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                    echo "<div class='day' data-date='$date'>$day</div>";
                }
                ?>
            </div>

            

            <!-- ป๊อปอัพเลือกปี -->
            <div id="yearPopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closeYearPopup()">&times;</span>
                    <h2>เลือกปี</h2>
                    <div id="yearList"></div>
                </div>
            </div>

        </div>  
        <div id="eventDetailsContainer" style="display: none;" class="grid-item1">
            <!-- รายละเอียดกิจกรรมจะถูกแสดงที่นี่ -->
            
            </div>
    </div>
    <iframe src="../notification/notification.php" style="display:none;"></iframe>
</bod>
</html>
