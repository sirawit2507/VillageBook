<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$error = "";
$success = "";

/* ดึงสถานที่ */
$places = $pdo->query("SELECT id, place_name FROM places ORDER BY place_name ASC")->fetchAll(PDO::FETCH_ASSOC);
/* ดึงสถานะการจองของผู้ใช้ */
$myBookings = $pdo->prepare("
    SELECT b.*, p.place_name
    FROM bookings b
    JOIN places p ON b.place_id = p.id
    WHERE b.user_id = ?
    ORDER BY b.booking_date DESC, b.start_time DESC
");
$myBookings->execute([$user_id]);
$myBookings = $myBookings->fetchAll(PDO::FETCH_ASSOC);

/* เมื่อกดจอง */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $place_id = $_POST['place_id'] ?? '';
    $booking_date = $_POST['booking_date'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';
    $note = trim($_POST['note'] ?? '');

    if ($place_id == '' || $booking_date == '' || $start_time == '' || $end_time == '') {
        $error = "กรุณากรอกข้อมูลให้ครบ";
    } elseif ($start_time >= $end_time) {
        $error = "เวลาเริ่มต้องน้อยกว่าเวลาสิ้นสุด";
    } else {

        // ✅ เช็คเวลาชน
        $check = $pdo->prepare("
            SELECT COUNT(*) 
            FROM bookings 
            WHERE place_id = ?
              AND booking_date = ?
              AND status IN ('pending','approved')
              AND (start_time < ? AND end_time > ?)
        ");
        $check->execute([$place_id, $booking_date, $end_time, $start_time]);

        if ($check->fetchColumn() > 0) {
            $error = "ช่วงเวลานี้ถูกจองแล้ว กรุณาเลือกเวลาใหม่";
        } else {

            // ✅ บันทึกการจอง
            $stmt = $pdo->prepare("
                INSERT INTO bookings (user_id, place_id, booking_date, start_time, end_time, note, status)
                VALUES (?, ?, ?, ?, ?, ?, 'pending')
            ");
            $stmt->execute([$user_id, $place_id, $booking_date, $start_time, $end_time, $note]);

            $success = "จองสำเร็จ! รอการอนุมัติจากแอดมิน";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>จองสถานที่</title>
<link rel="stylesheet" href="booking.css">
</head>
<body>

<div class="booking-container">
    <div class="booking-header">
        <div>
            <h2>📌 จองสถานที่</h2>
            <p>เลือกสถานที่ วัน และเวลา เพื่อทำการจอง</p>
        </div>
        <a href="index.php" class="back-btn">← กลับ</a>
    </div>

    <div class="booking-card">

        <?php if($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form class="booking-form" method="post">

            <div>
                <label>เลือกสถานที่</label>
                <select name="place_id" required>
                    <option value="">-- เลือกสถานที่ --</option>
                    <?php foreach($places as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['place_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label>วันที่จอง</label>
                <input type="date" name="booking_date" required>
            </div>

            <div>
                <label>เวลาเริ่ม</label>
                <input type="time" name="start_time" required>
            </div>

            <div>
                <label>เวลาสิ้นสุด</label>
                <input type="time" name="end_time" required>
            </div>

            <div class="full">
                <label>หมายเหตุ</label>
                <textarea name="note" placeholder="เช่น ต้องการโปรเจคเตอร์ / ขอเพิ่มเก้าอี้..."></textarea>
            </div>

            <div class="full">
                <button class="btn-submit" type="submit">✅ ยืนยันการจอง</button>
            </div>

        </form>

        <div class="summary-box">
            <h3>📌 ข้อแนะนำ</h3>
            <p>หากเวลาชน ระบบจะแจ้งเตือนให้เลือกเวลาใหม่ทันที เพื่อป้องกันการจองซ้ำ</p>
        </div>

    </div>
</div>

</body>
</html>
