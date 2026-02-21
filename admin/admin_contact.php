<?php
session_start();
require '../db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

/* ===== นับจำนวนข้อมูล ===== */

// จำนวนผู้ใช้
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$total_users = $stmt->fetchColumn();

// จำนวนสถานที่
$stmt = $pdo->query("SELECT COUNT(*) FROM places");
$total_places = $stmt->fetchColumn();

// จำนวนข้อความติดต่อ
$stmt = $pdo->query("SELECT COUNT(*) FROM contacts");
$total_contacts = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="admin-dark.css">
</head>
<body>

<div class="container">

<h2>📊 แดชบอร์ดผู้ดูแลระบบ</h2>

<div class="cards">

    <a href="manage_users.php" class="card">
        <h3>👥 ผู้ใช้งาน</h3>
        <p><?= $total_users ?></p>
    </a>

    <a href="manage_places.php" class="card">
        <h3>📍 สถานที่</h3>
        <p><?= $total_places ?></p>
    </a>

    <a href="contact.php" class="card">
        <h3>📩 ข้อความติดต่อ</h3>
        <p><?= $total_contacts ?></p>
    </a>

</div>

<br>
<a href="../logout.php">🚪 ออกจากระบบ</a>

</div>

</body>
</html>