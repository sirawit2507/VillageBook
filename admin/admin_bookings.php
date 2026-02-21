<?php
require '../db.php';

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
ORDER BY b.booking_date DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายการจองทั้งหมด</title>
<link rel="stylesheet" href="admin_bookings.css">
</head>

<body>

<div class="topbar">
    <div class="topbar-content">
        <h1>รายการจองทั้งหมด</h1>
        <a href="dashboard.php" class="back-btn">← กลับ Dashboard</a>
    </div>
</div>

<div class="container">
    <div class="table-box">

        <table class="booking-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อผู้จอง</th>
                    <th>สถานที่</th>
                    <th>วันที่</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>

            <?php if($stmt->rowCount() > 0): ?>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                   <td><?= $row['id'] ?></td>
                   <td><?= htmlspecialchars($row['user_name']) ?></td>
                   <td><?= htmlspecialchars($row['place_name']) ?></td>
                   <td><?= $row['booking_date'] ?></td>
                   <td>
                        <?php
                        $status = $row['status'];
                        $class = '';

                        if($status == 'pending') $class = 'pending';
                        elseif($status == 'approved') $class = 'approved';
                        elseif($status == 'rejected') $class = 'rejected';
                        ?>

                        <span class="status <?= $class ?>">
                            <?= ucfirst($status) ?>
                        </span>
                   </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">ไม่มีข้อมูลการจอง</td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>

    </div>
</div>

</body>
</html>