<?php
session_start();
require __DIR__ . '/../db.php';

/* ===== ลบข้อความ ===== */
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id=?");
    $stmt->execute([$id]);
    header("Location: admin_contact.php");
    exit;
}

/* ===== ดึงข้อมูล ===== */
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($contacts);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการข้อความติดต่อ</title>
<link rel="stylesheet" href="admin_contact.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="container">

    <!-- ✅ ปุ่มกลับ -->
    <a href="dashboard.php" class="back-btn">⬅ กลับหน้าแอดมิน</a>

    <h2 class="title">📩 ข้อความติดต่อ (<?= $total ?>)</h2>

    <div class="cards">
    <?php if(!empty($contacts)): ?>
        <?php foreach($contacts as $c): ?>
            <div class="card">

                <h3><?= htmlspecialchars($c['name']) ?></h3>
                <p class="email"><?= htmlspecialchars($c['email']) ?></p>

                <p class="message">
                    <?= substr(htmlspecialchars($c['message']),0,80) ?>...
                </p>

                <div class="date"><?= $c['created_at'] ?></div>

                <div class="actions">
                    <a href="?view=<?= $c['id'] ?>" class="btn view">👁 ดู</a>
                    <a href="?delete=<?= $c['id'] ?>"
                       onclick="return confirm('ลบข้อความนี้หรือไม่?')"
                       class="btn delete">❌ ลบ</a>
                </div>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-data">ยังไม่มีข้อความ</p>
    <?php endif; ?>
    </div>

</div>

<?php
/* ===== Modal ดูรายละเอียด ===== */
if(isset($_GET['view'])){
    $id = (int)$_GET['view'];
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id=?");
    $stmt->execute([$id]);
    $detail = $stmt->fetch(PDO::FETCH_ASSOC);

    if($detail):
?>
<div class="modal">
    <div class="modal-box">
        <h3><?= htmlspecialchars($detail['name']) ?></h3>
        <p><strong>Email:</strong> <?= htmlspecialchars($detail['email']) ?></p>
        <p><?= nl2br(htmlspecialchars($detail['message'])) ?></p>
        <div class="date"><?= $detail['created_at'] ?></div>
        <a href="admin_contact.php" class="close-btn">ปิด</a>
    </div>
</div>
<?php
    endif;
}
?>

</body>
</html>