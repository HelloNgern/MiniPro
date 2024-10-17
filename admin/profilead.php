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
</head>
<body>

<div class="row">
    <!-- ข้อมูลปัจจุบันของผู้ใช้ -->
    <div class="col-md-6 profile-info">
        <h4>ข้อมูลปัจจุบันของคุณ</h4><br>
        <p><strong>UserID:</strong> <?php echo $user['id']; ?></p>
        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Password:</strong> ********</p> <!-- ซ่อนรหัสผ่านด้วยการแสดง ******** -->
        <p><strong>Role:</strong> <?php echo $user['role']; ?></p>
        
        <!-- ปุ่มโยงไปยังหน้า edit -->
        <button onclick="location.href='editpro.php'" style="margin-top: 20px;">Edit Profile</button>
    </div>
</div>
</body>
</html>
