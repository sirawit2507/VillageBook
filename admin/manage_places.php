<?php
session_start();
require '../db.php';

$success = '';
$error = '';
$places = [];

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// ดึงข้อมูลสถานที่ทั้งหมด
try {
    $stmt = $pdo->query("SELECT * FROM places ORDER BY id DESC");
    $places = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "เกิดข้อผิดพลาดในการดึงข้อมูล";
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการสถานที่</title>
<link rel="stylesheet" href="manage_places.css">
</head>
<body>

<div class="container">

<h2>📍 จัดการสถานที่</h2>

<?php if ($success): ?>
    <div class="alert success"><?= $success ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert error"><?= $error ?></div>
<?php endif; ?>

<a href="add_place.php" class="btn-add">+ เพิ่มสถานที่</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>ชื่อสถานที่</th>
            <th>รายละเอียด</th>
            <th>การจัดการ</th>
        </tr>
    </thead>
    <tbody>

    <?php if (count($places) > 0): ?>
        <?php foreach ($places as $place): ?>
        <tr>
            <td><?= $place['id'] ?></td>
            <td><?= htmlspecialchars($place['place_name']) ?></td>
            <td><?= htmlspecialchars($place['description']) ?></td>
            <td>
                <a href="edit_place.php?id=<?= $place['id'] ?>" class="btn-edit">แก้ไข</a>
                <a href="delete_place.php?id=<?= $place['id'] ?>" 
                   class="btn-delete"
                   onclick="return confirm('คุณแน่ใจหรือไม่?')">ลบ</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" style="text-align:center;">ไม่มีข้อมูลสถานที่</td>
        </tr>
    <?php endif; ?>

    </tbody>
</table>
         <br>
    <a href="dashboard.php">⬅ กลับหน้าแอดมิน</a>
</div>

</body>
</html>