<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
    .main-content {
        margin-left: 300px;
        padding: 0px;
        margin-right: 10px;
    }
    
    
    </style>
    

</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="showdata.php">Dashboard</a></li>
            <li><a href="">Users Management</a></li>
            <li><a href="profilead.php">Profile Admin</a></li>
            <li><a onclick="lockoutUser()" href="#">Logout</a><li>  
        </ul>
    </div>
    <script>
    function lockoutUser() {
        if (confirm("คุณต้องการล็อกเอาท์ใช่ไหม?")) {
            window.location.href = '../home/logout.php'; 
        }
    }
    </script>

<?php
// เชื่อมต่อฐานข้อมูล
session_start();
if ($_SESSION['id'] == "") {
   header("Location: ../register/login.html"); // เปลี่ยนเส้นทางไปยังหน้า login.html
   exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์มค้นหา
$searchQuery = '';
if (isset($_POST['searchQuery'])) {
    $searchQuery = $_POST['searchQuery'];
}

// คำสั่ง SQL เพื่อค้นหาข้อมูลผู้ใช้
$sql = "SELECT * FROM users WHERE username LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%'";

$result = $conn->query($sql);

$conn->close();
?>

    <!-- Main Content Area -->
    <div class="main-content">
    <div class="search-bar">
    <form id="searchForm" method="POST">
        <table>
                <tr>
                    <th> <h1 class="head1">User Management</h1></th>
                    <th><input type="text" id="searchInput" placeholder="Search by username or email" name="searchQuery"></th>
                    <th> <button type="submit" class="btn1">Search</button></th>
                </tr>
               
        </table>
    </form>
</div>
       
        
        <div class="user-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <!-- User data will be populated here -->
                </tbody>
            </table>
        </div>

        <!-- Add User Button -->
        <button id="addUserBtn">Add New User</button>

        <!-- Modal for Adding/Editing User -->
        <div id="userModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add/Edit User</h2>
                <form id="userForm" action="addmember.php" method="POST" onsubmit="return validateAddmemberForm()">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                    
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    
                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="1">Admin</option>
                        <option value="0">User</option>
                    </select>

                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <button type="submit">Save User</button>
                </form>
            </div>
        </div>

        <!-- Modal for Editing User -->
<div id="userEditModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Edit User</h2>
        <form id="userEditForm" action="save_edit.php" method="POST" onsubmit="return validateEditForm()">
            <input type="hidden" id="userId" name="userId"> <!-- Hidden input to store user ID -->
            
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password">

            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="1">Admin</option>
                <option value="0">User</option>
            </select>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>
</div>
<!-- Delete Confirmation Modal -->
 <center>
<div id="deleteConfirmationModal" class="modal" >
  <div class="modal-content">
    <span class="close" id="closeDeleteModal">&times;</span>
    <h2>Confirm Deletion</h2>
    <p>Are you sure you want to delete this user?</p>
    <button id="confirmDeleteBtn">Yes, Delete</button>
    <button id="cancelDeleteBtn">Cancel</button>
  </div>
</div>
</center>

        
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script> <!-- Link to external JavaScript -->
</body>
</html>
