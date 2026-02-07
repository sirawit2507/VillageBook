<?php
require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/auth_admin.php";

// สรุปยอดรวม
$totalBookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$totalUsers    = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalPlaces   = $pdo->query("SELECT COUNT(*) FROM places")->fetchColumn();

// ดึงรายการจองล่าสุด
$sql = "SELECT b.id, b.booking_date, b.start_time, b.end_time, b.status,
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
<style>
body{font-family:Arial;background:#f4f6f8;margin:0;padding:20px;}
.box{max-width:1100px;margin:auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,.1);}
.cards{display:flex;gap:15px;flex-wrap:wrap;margin-bottom:20px;}
.card{flex:1;min-width:220px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:15px;}
.card h3{margin:0;font-size:16px;color:#333;}
.card p{margin:10px 0 0;font-size:28px;font-weight:bold;}
table{width:100%;border-collapse:collapse;margin-top:10px;}
th,td{border-bottom:1px solid #ddd;padding:10px;text-align:left;}
th{background:#f3f4f6;}
.badge{padding:4px 10px;border-radius:999px;font-size:12px;color:#fff;display:inline-block;}
.pending{background:#f59e0b;}
.approved{background:#22c55e;}
.rejected{background:#ef4444;}
</style>
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
        </tr>

        <?php foreach ($bookings as $b): ?>
            <tr>
                <td><?= (int)$b['id'] ?></td>
                <td><?= htmlspecialchars($b['username']) ?></td>
                <td><?= htmlspecialchars($b['place_name']) ?></td>
                <td><?= htmlspecialchars($b['booking_date']) ?></td>
                <td><?= htmlspecialchars($b['start_time']) ?> - <?= htmlspecialchars($b['end_time']) ?></td>
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
