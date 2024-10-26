<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
    /* Global Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    /* Sidebar Styles */
    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #2c3e50;
        position: fixed;
        top: 0;
        left: 0;
        padding: 20px;
    }

    .sidebar h2 {
        color: #ecf0f1;
        text-align: center;
        font-size: 22px;
        margin-bottom: 40px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar ul li {
        margin: 15px 0;
    }

    .sidebar ul li a {
        color: #bdc3c7;
        text-decoration: none;
        font-size: 18px;
        display: block;
        padding: 10px;
        border-radius: 4px;
        transition: background 0.3s;
    }

    .sidebar ul li a:hover {
        background-color: #34495e;
        color: #ecf0f1;
    }

    /* Main Content Styles */
    .main-content {
        margin-left: 285px; /* Leave space for the sidebar */
        padding: 20px;
    }

    .main-content h1 {
        font-size: 32px;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    /* Dashboard container layout */
    .dashboard-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px; /* Reduce space between boxes */
    }

    .stat-box {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        flex: 1 1 31%; /* Adjust width to 31% for 3 boxes in a row */
        text-align: center;
        min-width: 250px; /* Ensure a minimum width for smaller screens */
        max-width: 100%; /* Make sure boxes don't exceed container width */
    }

    .stat-box h2 {
        margin: 0;
        font-size: 24px;
        color: #34495e;
    }

    .stat-box p {
        margin: 5px 0;
        font-size: 18px;
        color: #7f8c8d;
    }

    /* Chart Styles */
    canvas {
        background-color: white;
        padding: 10px;
        margin-top: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        max-width: 100%;
    }
</style>

</head>
<body>
<?php
 session_start();
 if ($_SESSION['id'] == "" || $_SESSION['role'] != "1") {
    header("Location: ../register/login.html"); // เปลี่ยนเส้นทางไปยังหน้า login.html หรือหน้าอื่นๆ เช่นหน้าแจ้งเตือน
    exit();
}
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

// สรุปข้อมูลสำคัญ
// จำนวนผู้ใช้ทั้งหมด
$sql_total_users = "SELECT COUNT(*) as total FROM users";
$result_total_users = $conn->query($sql_total_users);
$total_users = $result_total_users->fetch_assoc()['total'];


// จำนวนผู้ใช้ที่แอคทีฟ
$sql_active_users = "SELECT COUNT(*) as total FROM users WHERE status = 'active'";
$result_active_users = $conn->query($sql_active_users);
$active_users = $result_active_users->fetch_assoc()['total'];

// จำนวนผู้ใช้ที่ไม่แอคทีฟ
$sql_inactive_users = "SELECT COUNT(*) as total FROM users WHERE status = 'inactive'";
$result_inactive_users = $conn->query($sql_inactive_users);
$inactive_users = $result_inactive_users->fetch_assoc()['total'];

// จำนวนบทบาท (admin/user)
$sql_role_admin = "SELECT COUNT(*) as total FROM users WHERE role = '1'";
$result_role_admin = $conn->query($sql_role_admin);
$admin_count = $result_role_admin->fetch_assoc()['total'];

$sql_role_user = "SELECT COUNT(*) as total FROM users WHERE role = '0'";
$result_role_user = $conn->query($sql_role_user);
$user_count = $result_role_user->fetch_assoc()['total'];


?>


    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="">Dashboard</a></li>
            <li><a href="dashboard.php">Users Management</a></li>
            <li><a href="profilead.php">Profile Admin</a></li>
            <li><a href="../home/homepage.php">Check Design</a></li>
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

    <!-- Main Content Area -->
    <div class="main-content">
        <h1>Dashboard</h1>

        <!-- Key Metrics/Statistics -->
        <div class="dashboard-container">
            <div class="stat-box">
                <h2>Total Users</h2>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="stat-box">
                <h2>Active Users</h2>
                <p><?php echo $active_users; ?></p>
            </div>
            <div class="stat-box">
                <h2>Inactive Users</h2>
                <p><?php echo $inactive_users; ?></p>
            </div>
            <div class="stat-box">
                <h2>Admins</h2>
                <p><?php echo $admin_count; ?></p>
            </div>
            <div class="stat-box">
                <h2>Regular Users</h2>
                <p><?php echo $user_count; ?></p>
            </div>
        </div>
        <?php
        $sql_user_growth = "SELECT MONTHNAME(created_at) as month, COUNT(id) as user_count FROM users GROUP BY MONTH(created_at)";
        $result_user_growth = $conn->query($sql_user_growth);
        
        $months = [];
        $user_counts = [];
        
        if ($result_user_growth->num_rows > 0) {
            while ($row = $result_user_growth->fetch_assoc()) {
                $months[] = $row['month'];
                $user_counts[] = $row['user_count'];
            }
        } else {
            // หากไม่มีข้อมูล ให้ใส่ข้อมูลเริ่มต้น
            $months = ['January', 'February', 'March', 'April', 'May'];
            $user_counts = [0, 0, 0, 0, 0];
        }
        
        
        ?>
<h1>User Growth</h1>
        <!-- Chart Area -->
        <canvas id="userGrowthChart" width="390" height="190"></canvas>
    

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('userGrowthChart').getContext('2d');
    
    // รับข้อมูลเดือนและจำนวนผู้ใช้จาก PHP
    var months = <?php echo json_encode($months); ?>;
    var userCounts = <?php echo json_encode($user_counts); ?>;
    
    var userGrowthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months, // ใช้ข้อมูลเดือนที่ดึงมาจากฐานข้อมูล
            datasets: [{
                label: 'User Growth',
                data: userCounts, // ใช้ข้อมูลจำนวนผู้ใช้ที่ดึงมาจากฐานข้อมูล
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?php
$sql_user_growth = "SELECT 
    MONTHNAME(created_at) as month, 
    COUNT(id) as user_count
    FROM users
    GROUP BY MONTH(created_at), YEAR(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)";
    
$result_user_growth = $conn->query($sql_user_growth);

$user_data = [];
if ($result_user_growth->num_rows > 0) {
    while ($row = $result_user_growth->fetch_assoc()) {
        $user_data[] = $row;
    }
}

// คำนวณอัตราการเติบโตของผู้ใช้
$growth_data = [];
for ($i = 1; $i < count($user_data); $i++) {
    $previous_count = $user_data[$i - 1]['user_count'];
    $current_count = $user_data[$i]['user_count'];
    
    if ($previous_count > 0) {
        $growth_rate = (($current_count - $previous_count) / $previous_count) * 100;
    } else {
        $growth_rate = 100; // หากเดือนก่อนหน้ามีผู้ใช้ 0 คน ถือว่าเติบโต 100%
    }
    
    $growth_data[] = [
        'month' => $user_data[$i]['month'],
        'growth_rate' => $growth_rate
    ];
}

// ส่งข้อมูลไปยัง JavaScript ในรูปแบบ JSON
$growth_json = json_encode($growth_data);
$conn->close();
?>
<h1>User Growth Rate</h1>

<!-- Canvas สำหรับแสดงกราฟ -->
<canvas id="growthChart" width="400" height="200"></canvas>
</div>
<script>
    // รับข้อมูลจาก PHP ที่ส่งมาในรูปแบบ JSON
    var growthData = <?php echo $growth_json; ?>;

    // แยกข้อมูลเดือนและอัตราการเติบโต
    var labels = growthData.map(function(data) {
        return data.month;
    });

    var growthRates = growthData.map(function(data) {
        return data.growth_rate;
    });

    // สร้างกราฟ Line Chart
    var ctx = document.getElementById('growthChart').getContext('2d');
    var growthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'User Growth Rate (%)',
                data: growthRates,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Growth Rate (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });
</script>




</body>
</html>
