<?php
require '../db.php';
require 'auth_admin.php';
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    margin: 0;
}
header {
    background: #0f172a;
    color: #fff;
    padding: 15px 30px;
}
.container {
    padding: 30px;
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}
.card {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}
.card a {
    display: block;
    padding: 12px;
    background: #2563eb;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    margin-top: 10px;
}
.card a:hover {
    background: #1d4ed8;
}
.logout {
    float: right;
    color: #fff;
    text-decoration: none;
}
</style>
</head>
<body>

<header>
    <h2>Admin Dashboard</h2>
    <a class="logout" href="../logout.php">🚪 ออกจากระบบ</a>
</header>

<div class="container">
    <h3>เมนูจัดการระบบ</h3>

    <div class="grid">

        <div class="card">
            <h4>📋 การจอง</h4>
            <a href="admin_bookings.php">ดูรายการจองทั้งหมด</a>
        </div>

        <div class="card">
            <h4>🏠 สถานที่</h4>
            <a href="manage_places.php">เพิ่ม/แก้ไขสถานที่</a>
        </div>

        <div class="card">
            <h4>👥 ผู้ใช้งาน</h4>
            <a href="manage_users.php">ตรวจสอบผู้ใช้งาน</a>
        
        </div>

        <div class="card">
            <h4>📊 รายงาน</h4>
            <a href="reports.php">ดูรายงานสรุป</a>
        </div>

    </div>
</div>

</body>
</html>
