<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- เชื่อมต่อ Font Awesome -->
    <link rel="stylesheet" href="../home/home.css"> 
    <title>รายการโปรด</title>
    <style>
        h1 {
            margin-top: -30px;
            text-align: center;
            margin-bottom: 20px;
        }

        .event-container {
            display: flex;
            flex-direction: column; /* จัดกล่องเป็นแนวยาว */
            gap: 20px;
            align-items: center; /* จัดกลางในแนวแกนหลัก */
        }

        .event-box {
            background-color: #E8A44B; /* สีพื้นหลัง */
            border-radius: 10px;
            padding: 15px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            transition: all 0.3s ease; /* เพิ่มการเคลื่อนไหว */
        }

        .event-box h3 {
            margin-top: 0;
            cursor: pointer; /* เปลี่ยนเคอร์เซอร์เมื่อวางเหนือหัวข้อ */
        }

        .color-indicator {
            width: 50px;
            height: 50px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .details {
            display: none; /* ซ่อนรายละเอียดเริ่มต้น */
            margin-top: 10px;
        }

        .no-favorites {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }

        .delete-button {
            position: absolute; /* ตั้งตำแหน่งปุ่มให้ติดกับกล่องกิจกรรม */
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            cursor: pointer;
            color: #FF0000;
            font-size: 20px;
        }

        .delete-button:hover {
            color:#fff ; /* เปลี่ยนสีเมื่อวางเมาส์เหนือปุ่ม */
        }
    </style>

</head>
<body>
    <div class="navbar">
        <h2> Remind me! <img src="../register/image/remindd.png" width="40" height="50"></h2>
        <div class="navbar">
            <a href="../home/homepage.php"><i class="fa fa-fw fa-home"></i>หน้าหลัก</a>
            <a href="../calendar/calendar.php"><i class="fa fa fa-calendar"></i> ปฏิทิน</a>
            <a class="active" href="../favpage/favpage.php"><i class="fa fas fa-heart"></i> รายการโปรด</a>
            <a href="../notification/notification.php"><i class="fa fa fa fa-bell"> </i>การแจ้งเตือน</a>
            <a href="../search/search.php" ><i class="fa fa-fw fa-search"></i>ค้นหา</a>
        </div>
        <div class="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="menu" id="menu">
        <a href="../profile/profile.php">โปรไฟล์</a>
        <a href="../support/support.php">สนับสนุน</a>
        <a onclick="lockoutUser()" href="#">ออกจากระบบ</a> <!-- ลิงก์ไปยังหน้า Logout -->
    </div>

    <div id="content">
    <h1>รายการโปรด</h1>
    <div class="event-container">
        <?php
         session_start();
         if ($_SESSION['id'] == "") {
            header("Location: ../register/login.html"); // เปลี่ยนเส้นทางไปยังหน้า login.html
            exit();
        }
        error_reporting(E_ALL); // เปิดการแสดงข้อผิดพลาดทั้งหมด
        ini_set('display_errors', 1); // แสดงข้อผิดพลาดบนหน้าเว็บ

        $conn = new mysqli("localhost", "root", "", "login_system");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM events WHERE user_id = ? and liked=1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='event-box'>";
                echo "<button class='delete-button' onclick='removeFavorite(" . $row['id'] . ")'><i class='fa fas fa-heart'></i></button>"; // ใช้ Font Awesome สำหรับรูปหัวใจ
                echo "<h3 onclick='toggleDetails(this)'>" . $row['title'] . "</h3>"; // คลิกเพื่อขยายรายละเอียด
                echo "<div class='details'>"; // สร้าง div สำหรับรายละเอียด
                echo "<p>สถานที่: " . $row['location'] . "</p>"; // แสดงสถานที่ในรายละเอียด
                echo "<p>รายละเอียด: " . $row['details'] . "</p>"; // แสดงรายละเอียดในรายละเอียด
                echo "<p>วันที่เริ่ม: " . $row['start_time'] . " - วันที่สิ้นสุด: " . $row['end_time'] . "</p>"; // แสดงวันในรายละเอียด
                echo "<div class='color-indicator' style='background-color: " . $row['color'] . ";'></div>"; // แสดงสี
                echo "<p> สถานะงาน: ". $row['status'] . "</p>";
                echo "</div>"; // ปิด div สำหรับรายละเอียด
                echo "</div>";
            }
        } else {
            echo "<p class='no-favorites'>ไม่มีรายการโปรดสำหรับคุณ</p>"; // ถ้าไม่มีข้อมูล
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>

    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu");
            menu.classList.toggle("show");
        }

        function toggleDetails(header) {
            const eventBox = header.parentElement; // รับกล่องกิจกรรม
            const details = eventBox.querySelector('.details'); // ค้นหารายละเอียดในกล่องกิจกรรมนี้

            // ปิดรายละเอียดของกล่องอื่น ๆ
            const allDetails = document.querySelectorAll('.details');
            allDetails.forEach(detail => {
                if (detail !== details) { // ถ้าไม่ใช่รายละเอียดของกล่องที่ถูกคลิก
                    detail.style.display = 'none'; // ซ่อนรายละเอียด
                }
            });

            // แสดงหรือซ่อนรายละเอียดของกล่องที่ถูกคลิก
            if (details.style.display === "block") {
                details.style.display = "none"; // หากเปิดอยู่ ให้ปิด
            } else {
                details.style.display = "block"; // หากปิด ให้เปิด
            }
        }

        function removeFavorite(id) {
            if (confirm("คุณต้องการลบกิจกรรมนี้ออกจากรายการโปรดใช่ไหม?")) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'remove_fav.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            // ลบกิจกรรมจากหน้าจอ
                            location.reload(); // รีเฟรชหน้าจอหลังจากลบสำเร็จ
                        } else {
                            console.error('ไม่สามารถลบกิจกรรมได้: ' + response.message);
                        }
                    }
                };

                // ส่ง event_id ไปยัง remove_fav.php
                xhr.send(JSON.stringify({ id: id }));
            }
        }
    </script>
    
    <script>
    function lockoutUser() {
        if (confirm("คุณต้องการล็อกเอาท์ใช่ไหม?")) {
            window.location.href = '../home/logout.php'; 
        }
    }
    function toggleMenu() {
        var menu = document.getElementById("menu");
        menu.classList.toggle("show");
    }
</script>
<iframe src="../notification/notification.php" style="display:none;"></iframe>
</body>
</html>
