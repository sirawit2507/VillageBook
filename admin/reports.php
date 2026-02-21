<?php
require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/auth_admin.php";

// สรุปยอดรวม
$totalBookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$totalUsers    = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalPlaces   = $pdo->query("SELECT COUNT(*) FROM places")->fetchColumn();

// ดึงรายการจองล่าสุด
$sql = "SELECT b.id, b.booking_date, b.start_time, b.end_time, 
               b.status, b.note,
               u.username,
               p.place_name
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN places p ON b.place_id = p.id
        ORDER BY b.id DESC
        LIMIT 50";

$bookings = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายงานการจอง</title>
<link rel="stylesheet" href="report.css">
</head>
<body>

<div class="box">
    <h2>📊 รายงานการจอง (Admin)</h2>
<a href="dashboard.php">⬅ กลับหน้าแอดมิน</a>
    <div class="cards">
        <div class="card">
            <h3>จำนวนการจองทั้งหมด</h3>
            <p><?= (int)$totalBookings ?></p>
        </div>
        <div class="card">
            <h3>จำนวนผู้ใช้ทั้งหมด</h3>
            <p><?= (int)$totalUsers ?></p>
        </div>
        <div class="card">
            <h3>จำนวนสถานที่ทั้งหมด</h3>
            <p><?= (int)$totalPlaces ?></p>
        </div>
    </div>

    <h3>📌 รายการจองล่าสุด 50 รายการ</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>ผู้จอง</th>
            <th>สถานที่</th>
            <th>วันที่</th>
            <th>เวลา</th>
            <th>สถานะ</th>
            <th>เพิ่มเติม</th>
        </tr>

        <?php foreach ($bookings as $b): ?>
            <tr>
                <td><?= (int)$b['id'] ?></td>
                <td><?= htmlspecialchars($b['username']) ?></td>
                <td><?= htmlspecialchars($b['place_name']) ?></td>
                <td><?= htmlspecialchars($b['booking_date']) ?></td>
                <td><?= htmlspecialchars($b['start_time']) ?> - <?= htmlspecialchars($b['end_time']) ?></td>
                <td><?= htmlspecialchars($b['note'] ?: '-') ?></td>
                <td>
                    <?php
                        $status = $b['status'] ?? 'pending';
                        $class = $status;
                        if (!in_array($class, ['pending','approved','rejected'])) $class = 'pending';
                    ?>
                    <span class="badge <?= $class ?>">
                        <?= htmlspecialchars($status) ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="dashboard.php">⬅ กลับหน้าแอดมิน</a>
</div>

</body>
</html>
