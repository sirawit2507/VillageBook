<?php
session_start();
require 'db.php';

// เช็กการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ดึงข้อมูลการจองของผู้ใช้ที่ล็อกอิน
$sql = "SELECT b.*, u.username AS user_name, p.place_name
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        LEFT JOIN places p ON b.place_id = p.id
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC, b.start_time DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$my_bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการจองของฉัน</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c7be5;
            --bg-color: #f5f7fb;
            --text-dark: #334155;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            margin: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h2 {
            margin: 0;
            color: var(--primary-color);
        }

        .btn-home {
            text-decoration: none;
            color: #64748b;
        }

        .btn-new-booking {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px 20px;
            border-bottom: 1px solid #edf2f7;
            text-align: left;
        }

        th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 0.85em;
        }

        tr:hover {
            background-color: #fcfdfe;
        }

        .place-name {
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 60px;
            background: white;
            border-radius: 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <div>
            <a href="index.php" class="btn-home">← กลับหน้าหลัก</a>
            <h2>📋 รายการจองของฉัน</h2>
        </div>
        <a href="booking.php" class="btn-new-booking">+ จองสถานที่เพิ่ม</a>
    </div>

    <?php if (count($my_bookings) > 0): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ชื่อผู้จอง</th>
                        <th>สถานที่</th>
                        <th>วันที่ใช้บริการ</th>
                        <th>ช่วงเวลา</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($my_bookings as $b): ?>
                        <tr>
                            <td>
                                <span class="place-name">
                                    <?= htmlspecialchars($b['user_name']) ?>
                                </span><br>
                                <small style="color:#94a3b8;">
                                    รหัสการจอง #<?= $b['id'] ?>
                                </small>
                            </td>

                            <td><?= htmlspecialchars($b['place_name']) ?></td>

                            <td>
                                <?= date('d M Y', strtotime($b['booking_date'])) ?>
                            </td>

                            <td>
                                <?= substr($b['start_time'], 0, 5) ?>
                                -
                                <?= substr($b['end_time'], 0, 5) ?> น.
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h3>ยังไม่มีรายการจอง</h3>
            <p>เริ่มจองสถานที่แรกของคุณได้เลย</p>
            <a href="booking.php" class="btn-new-booking">จองสถานที่</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
 