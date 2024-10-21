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
    <link rel="stylesheet" href="editpro.css">
    <title>Edit Profile</title>
    <style>
    .profile-pic img {
    width: 150px;
    height: 150px;
    border-radius: 50%; /* ทำให้รูปเป็นวงกลม */
    object-fit: cover; /* ทำให้รูปอยู่ในขนาดและสัดส่วนที่ถูกต้อง */
    border: 2px solid #ccc; /* สามารถเพิ่มกรอบบางๆ ให้ดูมีลูกเล่น */
}
    </style>
</head>
<body>

 <!-- Sidebar -->
 <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="showdata.php">Dashboard</a></li>
            <li><a href="dashboard.php">Users Management</a></li>
            <li><a href="">Profile Admin</a></li>
            
        </ul>
    </div>


<!-- ฟอร์มแก้ไขข้อมูล -->
<script>
    // ฟังก์ชันสำหรับแสดงพรีวิวรูปภาพและอัปโหลดฟอร์มอัตโนมัติ
    function previewAndUpload() {
        var fileInput = document.getElementById('profileInput');
        var image = document.getElementById('profileImage');
        var form = document.getElementById('uploadForm');

        // แสดงรูปพรีวิว
        var reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
        }
        reader.readAsDataURL(fileInput.files[0]);

        // ส่งฟอร์มอัตโนมัติ
        form.submit();
    }
</script>
<!-- ฟอร์มแก้ไขข้อมูล -->
<div class="col-md-6 profile-edit">
    <h4>แก้ไขข้อมูลที่ต้องการ</h4>
    <form action="updateproad.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <div class="profile-pic">
            <img id="profileImage" src="../uploads/<?php echo $user['profile_pic']; ?>" alt="Profile Picture" width="150" height="150">
            
            <!-- ฟอร์มการอัปโหลดรูป -->
            
                <input type="file" name="profile_pic" id="profileInput" accept="image/*"  onchange="previewAndUpload()">
            
        </div>

        <div class="form-floating mb-3 info-row">
            <strong>Username :</strong>
            <input type="text" class="form-control" id="editUsername" name="username" placeholder="Username" value="<?php echo $user['username']; ?>" required>
        </div>

        <div class="form-floating mb-3 info-row">
            <strong>Email :</strong>
            <input type="email" class="form-control" id="editEmail" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" required>
        </div>

        <div class="form-floating mb-3 info-row">
            <strong>Password :</strong>
            <input type="password" class="form-control" id="editPassword" name="password" placeholder="new password" required>
        </div>

        <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
    </form>
</div>


</body>
</html>


<?php
mysqli_close($conn);
?>