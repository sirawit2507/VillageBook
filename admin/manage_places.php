<?php
require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/auth_admin.php";

$success = "";
$error = "";

// เพิ่มสถานที่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_place'])) {
    $place_name = trim($_POST['place_name'] ?? '');

    if ($place_name === '') {
        $error = "กรุณากรอกชื่อสถานที่";
    } else {
        $stmt = $pdo->prepare("INSERT INTO places (place_name) VALUES (?)");
        $stmt->execute([$place_name]);
        $success = "เพิ่มสถานที่สำเร็จ!";
    }
}

// ลบสถานที่
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];

    if ($delete_id > 0) {
        $stmt = $pdo->prepare("DELETE FROM places WHERE id = ?");
        $stmt->execute([$delete_id]);
        header("Location: manage_places.php");
        exit;
    }
}

// ดึงรายการสถานที่ทั้งหมด
$places = $pdo->query("SELECT * FROM places ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการสถานที่</title>
<style>
body { font-family: Arial; background:#f4f6f8; margin:0; padding:20px; }
.box { max-width:700px; margin:auto; background:#fff; padding:20px; border-radius:12px; }
input, button { padding:10px; }
table { width:100%; border-collapse: collapse; margin-top:15px; }
th, td { border-bottom:1px solid #ddd; padding:10px; text-align:left; }
a.btn { padding:6px 10px; border-radius:6px; text-decoration:none; color:#fff; }
.edit { background:#2563eb; }
.del { background:#dc2626; }
</style>
</head>
<body>

<div class="box">
    <h2>🏠 จัดการสถานที่</h2>

    <?php if ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="place_name" required placeholder="เช่น สระว่ายน้ำ">
        <button type="submit" name="add_place">เพิ่มสถานที่</button>
    </form>

    <hr>

    <h3>รายการสถานที่</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>ชื่อสถานที่</th>
            <th>จัดการ</th>
        </tr>

        <?php foreach ($places as $p): ?>
            <tr>
                <td><?= (int)$p['id'] ?></td>
                <td><?= htmlspecialchars($p['place_name']) ?></td>
                <td>
                    <a class="btn edit" href="place_edit.php?id=<?= (int)$p['id'] ?>">แก้ไข</a>
                    <a class="btn del"
                       href="manage_places.php?delete_id=<?= (int)$p['id'] ?>"
                       onclick="return confirm('คุณต้องการลบสถานที่นี้ใช่ไหม?');">
                       ลบ
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="dashboard.php">⬅ กลับหน้าแอดมิน</a>
</div>

</body>
</html>
