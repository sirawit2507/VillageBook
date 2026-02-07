<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดต่อเรา - VillageBook</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2c7be5;
            --secondary: #6e84a3;
            --bg: #f5f7fb;
            --white: #ffffff;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: var(--bg);
            margin: 0;
            color: #333;
        }

        /* Navigation Style (เหมือนหน้าแรก) */
        nav {
            background: var(--white);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        nav .logo { font-size: 24px; font-weight: bold; color: var(--primary); text-decoration: none; }
        nav .nav-links a { margin-left: 20px; text-decoration: none; color: var(--secondary); font-weight: 500; }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .contact-info {
            background: var(--primary);
            color: white;
            padding: 40px;
            border-radius: 15px;
        }

        .contact-info h2 { margin-top: 0; }
        .info-item { margin-bottom: 25px; display: flex; align-items: center; }
        .info-item span { margin-left: 15px; font-size: 1.1em; }

        .contact-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: 'Sarabun', sans-serif;
        }

        .btn-send {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
        }

        @media (max-width: 768px) {
            .container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php" class="logo">VillageBook</a>
    <div class="nav-links">
        <a href="index.php">หน้าแรก</a>
        <a href="contact.php" style="color: var(--primary);">ติดต่อเรา</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php" style="color: #e63757;">ออกจากระบบ</a>
        <?php else: ?>
            <a href="login.php">เข้าสู่ระบบ</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container">
    <div class="contact-info">
        <h2>ช่องทางการติดต่อ</h2>
        <p>หากคุณพบปัญหาในการจองสถานที่ หรือต้องการสอบถามข้อมูลเพิ่มเติม สามารถติดต่อสำนักงานนิติบุคคลได้ตามช่องทางด้านล่างนี้</p>
        
        <div class="info-item">
            <strong>📞 เบอร์โทรศัพท์:</strong>
            <span>02-123-4567</span>
        </div>
        <div class="info-item">
            <strong>📧 อีเมล:</strong>
            <span>support@villagebook.com</span>
        </div>
        <div class="info-item">
            <strong>💬 LINE ID:</strong>
            <span>@village_care</span>
        </div>
        <div class="info-item">
            <strong>📍 ที่ตั้ง:</strong>
            <span>อาคารสโมสร ชั้น 1 หมู่บ้านวิลเลจบุ๊ค</span>
        </div>
    </div>

    <div class="contact-form">
        <h3>ส่งข้อความถึงเรา</h3>
        <form action="#" method="POST">
            <div class="form-group">
                <label>ชื่อ-นามสกุล</label>
                <input type="text" name="name" placeholder="ระบุชื่อของคุณ" required>
            </div>
            <div class="form-group">
                <label>หัวข้อติดต่อ</label>
                <input type="text" name="subject" placeholder="เช่น แจ้งปัญหาการจอง" required>
            </div>
            <div class="form-group">
                <label>รายละเอียด</label>
                <textarea name="message" rows="5" placeholder="ระบุรายละเอียดที่ต้องการสอบถาม"></textarea>
            </div>
            <button type="submit" class="btn-send">ส่งข้อความ</button>
        </form>
    </div>
</div>

</body>
</html>