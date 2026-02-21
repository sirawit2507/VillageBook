<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* ดึงสถานะการจองของผู้ใช้ */
$stmt = $pdo->prepare("
    SELECT b.booking_date, b.start_time, b.end_time, b.note, b.status, p.place_name
    FROM bookings b
    JOIN places p ON b.place_id = p.id
    WHERE b.user_id = ?
    ORDER BY b.booking_date DESC, b.start_time DESC
");
$stmt->execute([$user_id]);
$myBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>สถานะการจอง</title>
<link rel="stylesheet" href="my_booking.css?v=3">
</head>
<body>

<div class="status-box">
    <a href="index.php" class="back-btn">← กลับหน้าหลัก</a>

    <h3>📋 สถานะการจองของคุณ</h3>

    <?php if (empty($myBookings)): ?>
        <p class="empty">ยังไม่มีรายการจอง</p>
    <?php else: ?>
        <table class="status-table">
            <thead>
                <tr>
                    <th>สถานที่</th>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>สถานะ</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($myBookings as $b): ?>
                    <?php $status = $b['status'] ?? 'pending'; ?>
                    <tr>
                        <td><?= htmlspecialchars($b['place_name']) ?></td>
                        <td><?= htmlspecialchars($b['booking_date']) ?></td>
                        <td><?= substr($b['start_time'],0,5) ?> - <?= substr($b['end_time'],0,5) ?></td>
                        <td>
                            <span class="status <?= $status ?>">
                                <?= $status === 'pending'
                                    ? 'รออนุมัติ'
                                    : ($status === 'approved'
                                        ? 'อนุมัติแล้ว'
                                        : 'ไม่อนุมัติ') ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($b['note'] ?: '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
