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
    <title>Edit Profile</title>

</head>
<body>
<!-- ฟอร์มแก้ไขข้อมูล -->
<div class="col-md-6 profile-edit">
                <h4>แก้ไขข้อมูลที่ต้องการ</h4>
                <form action="updateproad.php" method="post">
                    <!-- เพิ่ม hidden input สำหรับ UserID -->
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editUsername" name="username" placeholder="Username" value="<?php echo $user['username']; ?>" required>
                        <label for="editUsername">Username</label>
                    </div>

                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="editEmail" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" required>
                        <label for="editEmail">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="editPassword" name="password" placeholder="new password" value="<?php echo $user['password']; ?>" required>
                        <label for="editPassword">Password</label>
                    </div>

                    <!-- <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="confirm-password" placeholder="confirm new password">
                        <label for="confirm-password">confirm password :</label>
                    </div> -->

                    <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>


<?php
mysqli_close($conn);
?>