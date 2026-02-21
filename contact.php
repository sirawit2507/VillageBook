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
    <link rel="stylesheet" href="contact.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- ===== Navbar ===== -->
<nav>
    <a href="index.php" class="logo">VillageBook</a>
    
</nav>

<!-- ===== Contact Container ===== -->
<div class="contact-container">

  <div class="contact-header">
    <div>
      <h2>📞 ติดต่อเรา</h2>
      <p>สอบถามข้อมูลหรือแจ้งปัญหาการใช้งาน</p>
    </div>
    <a href="index.php" class="back-btn">← กลับ</a>
  </div>

  <div class="contact-info">
    <div class="info-card">
      <h4>ที่อยู่</h4>
      <p>หมู่บ้าน XYZ</p>
    </div>
    <div class="info-card">
      <h4>เบอร์โทร</h4>
      <p>099-999-9999</p>
    </div>
    <div class="info-card">
      <h4>อีเมล</h4>
      <p>admin@village.com</p>
    </div>
  </div>

  <form class="contact-form">
    <div>
      <label>ชื่อ</label>
      <input type="text">
    </div>

    <div>
      <label>อีเมล</label>
      <input type="email">
    </div>

    <div class="full">
      <label>ข้อความ</label>
      <textarea></textarea>
    </div>

    <button type="submit" class="btn-send">📨 ส่งข้อความ</button>
  </form>

</div>

</body>
</html>