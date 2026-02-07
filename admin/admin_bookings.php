<?php
require '../db.php';
session_start();

$sql = "
    SELECT 
        b.id,
        u.username AS user_name,
        p.place_name,
        b.booking_date,
        b.start_time,
        b.end_time,
        b.status
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN places p ON b.place_id = p.id
    ORDER BY b.booking_date DESC, b.start_time DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายการจองทั้งหมด</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
}
.container {
    padding: 30px;
}
table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
}
th, td {
    padding: 14px;
    border-bottom: 1px solid #e5e7eb;
    text-align: center;
}
th {
    background: #2563eb;
    color: #fff;
}
.status-wait { color: orange; font-weight: bold; }
.status-approve { color: green; font-weight: bold; }
.status-cancel { color: red; font-weight: bold; }
.back {
    display: inline-block;
    margin-bottom: 15px;
    text-decoration: none;
    color: #2563eb;
}
</style>
</head>
<body>

<div class="container">

<a class="back" href="dashboard.php">← กลับหน้าแอดมิน</a>

<h2>📋 รายการจองสถานที่</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ชื่อผู้จอง</th>
        <th>สถานที่</th>
        <th>วัน</th>
        <th>เวลา</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
    </tr>

    <?php foreach ($bookings as $b): ?>
    <tr>
        <td><?= htmlspecialchars($b['user_name']) ?></td>
        <td><?= htmlspecialchars($b['place_name']) ?></td>
        <td><?= $b['booking_date'] ?></td>
        <td><?= $b['start_time'] ?> - <?= $b['end_time'] ?></td>
        <td><?= $b['status'] ?></td>
        <td>
            <?php if ($b['status'] === 'pending'): ?>
                <a href="update_booking.php?id=<?= $b['id'] ?>&status=approved">
                    <button style="background:green;color:white;">อนุมัติ</button>
                </a>
                <a href="update_booking.php?id=<?= $b['id'] ?>&status=rejected">
                    <button style="background:red;color:white;">ยกเลิก</button>
                </a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</div>
</body>
</html>
