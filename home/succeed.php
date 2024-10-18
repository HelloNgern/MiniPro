<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่า session มีค่า user_id หรือไม่
if (!isset($_SESSION['id'])) {
    die("Error: User not logged in.");
}

// ดึงข้อมูลกิจกรรมที่มี status เป็น 3
$userId = $_SESSION['id'];
$sql = "SELECT id, title, location, details, color, start_time, end_time, liked, share_email, status FROM events WHERE user_id = ? AND status = 3";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กิจกรรมที่สำเร็จ</title>
    <link rel="stylesheet" href="todo.css"> <!-- เชื่อมโยงไฟล์ CSS ถ้ามี -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- ใช้ jQuery -->
    <script>
        function toggleDetails(eventId) {
            const detailsElement = document.getElementById('details-' + eventId);
            detailsElement.style.display = (detailsElement.style.display === 'block') ? 'none' : 'block';
        }

        function deleteEvent(eventId) {
            $.ajax({
                url: 'delete_event.php', // ไฟล์ PHP สำหรับลบ event
                type: 'POST',
                data: { event_id: eventId },
                success: function(response) {
                    // ถ้าลบ event สำเร็จให้ทำการรีเฟรชหรือซ่อน event นั้น
                    if (response == 'success') {
                        $('#event-' + eventId).remove(); // ลบ event ออกจาก DOM
                    } else {
                        alert('เกิดข้อผิดพลาดในการลบกิจกรรม');
                    }
                }
            });
        }
    </script>
</head>
<body>
<a href="homepage.php" class="back-button">ย้อนกลับ</a>
    <h1>เสร็จสินแล้ว</h1>

    <div class="todo-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="todo-item" id="event-<?= $row['id'] ?>" onclick="toggleDetails(<?= $row['id'] ?>)" style="border-left: 5px solid <?= htmlspecialchars($row['color']) ?>;">
                    <h2 class="todo-title"><?= htmlspecialchars($row['title']) ?></h2>
                    <div class="todo-details" id="details-<?= $row['id'] ?>" style="display: none;">
                        <p><strong>สถานที่:</strong> <?= htmlspecialchars($row['location']) ?></p>
                        <p><strong>รายละเอียด:</strong> <?= htmlspecialchars($row['details']) ?></p>
                        <p><strong>เริ่มเวลา:</strong> <?= htmlspecialchars($row['start_time']) ?></p>
                        <p><strong>สิ้นสุดเวลา:</strong> <?= htmlspecialchars($row['end_time']) ?></p>
                        <p><strong>อีเมลแชร์:</strong> <?= htmlspecialchars($row['share_email']) ?></p>
                        
                        <button class="delete-button" onclick="event.stopPropagation(); deleteEvent(<?= $row['id'] ?>)">ลบกิจกรรม</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-events-message">ไม่มีกิจกรรมที่เสร็จสินแล้ว</p>
            <style>
    .no-events-message {
        background-color: #f8d7da; /* สีพื้นหลังแดงอ่อน */
        color: #721c24; /* สีข้อความแดงเข้ม */
        border: 1px solid #f5c6cb; /* ขอบสีแดง */
        border-radius: 5px; /* มุมโค้ง */
        padding: 15px; /* ช่องว่างภายใน */
        text-align: center; /* จัดกลาง */
        margin-top: 20px; /* ช่องว่างด้านบน */
        font-size: 1.2em; /* ขนาดตัวอักษร */
        font-weight: bold; /* ตัวหนา */
    }
</style>
        <?php endif; ?>

        <style>
            .backk-button {
                position: absolute;
                margin-top:10px;
                left: 25px;
                color: #FFFFFF; /* กำหนดสีข้อความเป็นสีขาว */
                border: none; /* ไม่ต้องการเส้นขอบ */
                border-radius: 5px; /* ทำให้มุมปุ่มโค้งมน */
                text-decoration: underline; /* เพิ่มขีดเส้นใต้ */
                font-size: 16px; /* ขนาดอักษรตามต้องการ */
            }
            .backk-button:hover {
                color:#ed3636; /* เปลี่ยนสีเมื่อชี้เมาส์ */
            }
        </style>
        <a href="doing.php" class="backk-button">< กำลังดำเนินการ</a>

    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
