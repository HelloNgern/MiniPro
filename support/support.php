<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
     session_start();
     if ($_SESSION['id'] == "") {
        header("Location: ../register/login.html"); // เปลี่ยนเส้นทางไปยังหน้า login.html
        exit();
    }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .container1{
    max-width: 1100px;
    width: 97%;
    background: #fff;
    border-radius: 12px;
    margin-left: 37px;
    margin-top: 25px;
    margin-bottom: 20px;
    padding: 20px 50px 40px 40px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}

    /* สไตล์ของ slider */
    .slider {
            position: relative;
            max-width: 100%; /* กำหนดความกว้างสูงสุดให้เต็มพื้นที่ */
            margin: auto;
            overflow: hidden; /* ซ่อนเนื้อหาที่เกินออกจาก container */
        }

        .slides {
            display: flex;
        }

        .slide {
            min-width: 100%; /* แต่ละสไลด์มีขนาดเท่ากับพื้นที่ทั้งหมด */
            transition: transform 0.5s ease-in-out;
        }

        .slide img {
            width: 100%; /* กำหนดภาพให้เต็มสไลด์ */
            height: auto;
        }

        /* ปุ่มเลื่อนซ้ายขวา */
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev {
            left: 0;
            border-radius: 3px 0 0 3px;
        }

        /* ปุ่มเมื่อชี้เมาส์ */
        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>

    
</head>
<body>
    <!-- ส่วนของ Navbar -->
    <div class="navbar">
            <h2> Remind me! <img src="../register/image/remindd.png" width="40" height="50"></h2>

            <div class="navbar">
                <a href="../home/homepage.php"><i class="fa fa-fw fa-home"></i>หน้าหลัก</a>
                <a href="../calendar/calendar.php"><i class="fa fa fa-calendar"></i> ปฏิทิน</a>
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
        <a href="../support/support.php">สนับสนุน</a>
        <a onclick="lockoutUser()" href="#">ออกจากระบบ</a> <!-- ลิงก์ไปยังหน้า Logout -->
    </div>


    <div class="container1">
            <div class="main-title1">สนับสนุน</div>
            <div class="content1">
                <input type="radio" name="indicator" checked id="help">
                <input type="radio" name="indicator" id="aboutUs">
                <input type="radio" name="indicator" id="contactUs">
            <div class="list1">
                <label for="help" class="help">
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                    <span class="topic">ช่วยเหลือ</span>
                </label>
                <label for="aboutUs" class="aboutUs">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <span class="topic">เกี่ยวกับเรา</span>
                </label>
                <label for="contactUs" class="contactUs">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <span class="topic">ติดต่อ</span>
                </label>
                <div class="indicator"></div>
            </div>

            <div class="text-content">
                <div class="help text">
                    <div class="title"></i>ช่วยเหลือ<i class="fa-solid fa-circle-question"></i></div>
                <p>
                    <div class="slider">
                        <div class="slides">
                            <!-- Each image inside the slider -->
                            <div class="slide"><img src="imageja/1.png" alt="Image 1"></div>
                            <div class="slide"><img src="imageja/2.png" alt="Image 2"></div>
                            <div class="slide"><img src="imageja/3.png" alt="Image 3"></div>
                            <div class="slide"><img src="imageja/4.png" alt="Image 4"></div>
                            <div class="slide"><img src="imageja/5.png" alt="Image 5"></div>
                            <div class="slide"><img src="imageja/6.png" alt="Image 6"></div>
                            <div class="slide"><img src="imageja/7.png" alt="Image 7"></div>
                            <div class="slide"><img src="imageja/8.png" alt="Image 8"></div>
                            <div class="slide"><img src="imageja/9.png" alt="Image 9"></div>
                        </div>
                        
                        <!-- Navigation buttons -->
                        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
                        <button class="next" onclick="moveSlide(1)">&#10095;</button>
                    </div>
                </p>
            </div>
            <div class="aboutUs text">
                <div class="title">เกี่ยวกับ Remind me!</div>
                <p>ยินดีต้อนรับสู่ Remind Me! แพลตฟอร์มการจัดการกิจกรรมที่ถูกออกแบบมาเพื่อช่วยให้ทุกคนสามารถจัดกิจกรรมได้อย่างง่ายดาย ไม่ว่าจะเป็นการจัดกิจกรรมขนาดเล็กสำหรับกลุ่มเพื่อนหรือกิจกรรมใหญ่ระดับองค์กร เรามุ่งมั่นที่จะทำให้กระบวนการจัดการกิจกรรมทุกขั้นตอนเป็นไปอย่างราบรื่น สะดวกสบาย และประหยัดเวลา<br>
                    <br>
                    ภารกิจของเรา<br>
                    เราเชื่อว่าการจัดกิจกรรมไม่ควรเป็นเรื่องยุ่งยาก นั่นเป็นเหตุผลที่เราพัฒนาแพลตฟอร์มที่ช่วยให้ผู้ใช้งานสามารถ วางแผน จัดการ และโปรโมตกิจกรรมได้ในที่เดียว เราออกแบบ Remind Me! เพื่อให้รองรับทุกประเภทของกิจกรรม ตั้งแต่การจัดการตารางเวลา การลงทะเบียนผู้เข้าร่วม การแจ้งเตือนอัตโนมัติ จนถึงการติดตามผลหลังจบงาน<br>
                    <br>
                    ฟีเจอร์หลักของเรา<br>
                    การสร้างกิจกรรมที่ง่ายและรวดเร็ว : เพียงไม่กี่ขั้นตอน คุณสามารถสร้างกิจกรรมที่ต้องการได้ ทั้งการตั้งค่าการเข้าร่วม การกำหนดเวลาและสถานที่<br>
                    ระบบแจ้งเตือนอัตโนมัติ : ไม่พลาดทุกการอัปเดต! ผู้เข้าร่วมจะได้รับการแจ้งเตือนล่วงหน้าเกี่ยวกับกิจกรรม ไม่ว่าจะเป็นการเปลี่ยนแปลงตารางหรือข่าวสารที่สำคัญ<br>
                    การลงทะเบียนออนไลน์ : ผู้เข้าร่วมสามารถลงทะเบียนเข้าร่วมกิจกรรมผ่านระบบของเราได้อย่างง่ายดาย พร้อมทั้งติดตามสถานะการลงทะเบียนและข้อมูลการเข้าร่วม<br>
                    การจัดการหลายกิจกรรม : สำหรับผู้จัดกิจกรรมที่มีหลายงานพร้อมกัน ระบบของเราช่วยให้คุณสามารถจัดการหลายกิจกรรมได้ในเวลาเดียวกัน<br>
                    <br>
                    เป้าหมายของเรา<br>
                    Remind Me! มุ่งมั่นที่จะเป็นเครื่องมือที่ช่วยลดภาระของผู้จัดงาน และเพิ่มประสิทธิภาพในการจัดกิจกรรม เราต้องการให้ทุกกิจกรรมไม่ว่าจะเล็กหรือใหญ่ สำเร็จลุล่วงได้ด้วยความราบรื่น ด้วยการเชื่อมต่อผู้จัดและผู้เข้าร่วมเข้าด้วยกันอย่างลงตัว<br>
                    <br>
                    ทีมงานของเรา<br>
                    ทีมงานของเราประกอบด้วยผู้เชี่ยวชาญด้านการพัฒนาเทคโนโลยีและการจัดการกิจกรรม เราเข้าใจความท้าทายในการจัดการงานต่างๆ และเรายินดีที่จะให้คำปรึกษาและสนับสนุนผู้ใช้งานทุกท่านอย่างเต็มที่<br>
                    <br>
                    ติดต่อเรา<br>
                    หากคุณมีคำถามหรือข้อสงสัย สามารถติดต่อเราได้ผ่านช่องทางต่างๆ ในหน้า Contact Us เราพร้อมที่จะรับฟังข้อเสนอแนะและช่วยแก้ไขปัญหา เพื่อให้คุณได้รับประสบการณ์ที่ดีที่สุด<br>
                    <br>
                    Remind Me! - ทุกกิจกรรมเป็นเรื่องง่ายกว่าที่เคย
                </p>
            </div>
            <div class="contactUs text">
                <div class="title">ติดต่อสอบถาม</div>
                <p>เรายินดีที่จะให้ความช่วยเหลือและตอบคำถามของคุณ หากคุณต้องการติดต่อเราเกี่ยวกับการใช้งานเว็บไซต์ Remind Me! หรือต้องการสอบถามข้อมูลเพิ่มเติมเกี่ยวกับการจัดการกิจกรรม กรุณาเลือกช่องทางการติดต่อที่สะดวกที่สุดตามรายละเอียดด้านล่าง : <br>
                    <br>
                    ช่องทางการติดต่อ<br>
                    1. อีเมล :<br>
                    สำหรับข้อสงสัยทั่วไป: support@remindme.com<br>
                    สำหรับข้อเสนอแนะหรือปัญหาการใช้งาน: feedback@remindme.com<br>
                    <br>
                    2. โทรศัพท์ :<br>
                    ฝ่ายบริการลูกค้า: +66 1234 5678<br>
                    เวลาทำการ: วันจันทร์ - ศุกร์ เวลา 9:00 - 18:00 น. (ยกเว้นวันหยุดราชการ)<br>
                    <br>
                    3. ที่อยู่สำนักงาน :
                    123 อาคาร Remind Me! ถนนสาทร กรุงเทพฯ 10120<br>
                    <br>
                    โซเชียลมีเดีย :<br>
                    ติดตามข่าวสารและอัปเดตต่างๆ ของเราได้ทางโซเชียลมีเดีย :<br>
                    Facebook: facebook.com/remindme<br>
                    Twitter: @remindme<br>
                    Instagram: @remindme_official<br>

                    เรามุ่งมั่นที่จะให้การสนับสนุนที่ดีที่สุดแก่ผู้ใช้งานทุกท่าน ทีมงานของเราพร้อมที่จะช่วยคุณให้การจัดการกิจกรรมเป็นเรื่องง่ายและราบรื่นมากยิ่งขึ้น!<br>
                    <br>
                    Remind Me! - ทุกกิจกรรมสำเร็จได้ง่ายกว่าที่คิด
                </p>
            </div>
            </div>
    </div>
    </div>
    
    <script>
        let currentSlide = 0; // กำหนดสไลด์เริ่มต้นที่ตำแหน่งแรก

        function showSlide(index) {
            const slides = document.querySelectorAll('.slide');
            // ถ้าเลื่อนไปมากกว่าจำนวนสไลด์ ให้กลับไปที่สไลด์แรก
            if (index >= slides.length) {
                currentSlide = 0;
            }
            // ถ้าเลื่อนไปตำแหน่งที่น้อยกว่า 0 ให้กลับไปที่สไลด์สุดท้าย
            if (index < 0) {
                currentSlide = slides.length - 1;
            }

            // ซ่อนสไลด์ทั้งหมด
            slides.forEach(slide => {
                slide.style.display = 'none';
            });

            // แสดงสไลด์ที่ตรงกับ index ปัจจุบัน
            slides[currentSlide].style.display = 'block';
        }

        function moveSlide(step) {
            currentSlide += step;
            showSlide(currentSlide);
        }

        // เรียกใช้เพื่อแสดงสไลด์แรกตอนโหลดหน้า
        window.onload = function() {
            showSlide(currentSlide);
        };
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
    <script src="imageSlider.js"></script>

</body>
</html>
