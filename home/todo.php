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

// ดึงข้อมูลกิจกรรมจากฐานข้อมูล
$userId = $_SESSION['id'];
$sql = "SELECT id, title, location, details, color, start_time, end_time, liked, share_email FROM events WHERE user_id = ?";
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
    <title>สิ่งที่ต้องทำ</title>
    <link rel="stylesheet" href="todo.css"> <!-- เชื่อมโยงไฟล์ CSS ถ้ามี -->
    <script>
        function toggleDetails(eventId) {
            const detailsElement = document.getElementById('details-' + eventId);
            detailsElement.style.display = (detailsElement.style.display === 'block') ? 'none' : 'block';
        }
    </script>
</head>
<body>
    <h1>สิ่งที่ต้องทำ</h1>

    <div class="todo-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="todo-item" onclick="toggleDetails(<?= $row['id'] ?>)" style="border-left: 5px solid <?= htmlspecialchars($row['color']) ?>;">
                <h2  class="todo-title"><?= htmlspecialchars($row['title']) ?></h2>
                <div class="todo-details" id="details-<?= $row['id'] ?>" style="display: none;">
                    <p><strong>สถานที่:</strong> <?= htmlspecialchars($row['location']) ?></p>
                    <p><strong>รายละเอียด:</strong> <?= htmlspecialchars($row['details']) ?></p>
                    <p><strong>เริ่มเวลา:</strong> <?= htmlspecialchars($row['start_time']) ?></p>
                    <p><strong>สิ้นสุดเวลา:</strong> <?= htmlspecialchars($row['end_time']) ?></p>
                    <p><strong>อีเมลแชร์:</strong> <?= htmlspecialchars($row['share_email']) ?></p>
                    
                    <button class="move-button" onclick="moveToDoing(<?= $row['id'] ?>)">ดำเนินการ</button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

  

    <script>
        function moveToDoing(eventId) {
            // ส่งข้อมูลกิจกรรมไปยัง doing.php
            window.location.href = 'doing.php?id=' + eventId;
        }
    </script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
