<?php
require '../db.php';
require 'auth_admin.php';
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<!-- เรียกใช้ไฟล์ CSS แยก -->
<link rel="stylesheet" href="dashboard.css">
</head>

<body>

<!-- แถบบน -->
<div class="topbar">
    <div class="topbar-content">
        <h1>Admin Dashboard</h1>
        <a href="../logout.php" class="logout-btn">🚪 ออกจากระบบ</a>
    </div>
</div>

<!-- เนื้อหา -->
<div class="container">

    <h2 class="section-title">เมนูจัดการระบบ</h2>

    <div class="card-grid">

        <div class="card">
            <div class="card-icon">📋</div>
            <h3>การจอง</h3>
            <a href="admin_bookings.php" class="card-btn">
                ดูรายการจองทั้งหมด
            </a>
        </div>

        <div class="card">
            <div class="card-icon">🏠</div>
            <h3>สถานที่</h3>
            <a href="manage_places.php" class="card-btn">
                เพิ่ม/แก้ไขสถานที่
            </a>
        </div>

        <div class="card">
            <div class="card-icon">👥</div>
            <h3>ผู้ใช้งาน</h3>
            <a href="manage_users.php" class="card-btn">
                ตรวจสอบผู้ใช้งาน
            </a>
        </div>

        <div class="card">
            <div class="card-icon">📊</div>
            <h3>รายงาน</h3>
            <a href="reports.php" class="card-btn">
                ดูรายงานสรุป
            </a>
        </div>
<div class="card">
    <div style="font-size:40px;">📩</div>
    <h3>ติดต่อเรา</h3>
    <a href="contact.php" class="btn">ดูข้อความติดต่อ</a>
</div>
    </div>
</div>

</body>
</html>