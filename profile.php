<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = "";

// ดึงข้อมูลผู้ใช้ (ใช้ username อย่างเดียว)
$stmt = $pdo->prepare("SELECT id, username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// กดบันทึก
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);

    if ($username == "") {
        $msg = "❌ กรุณากรอกชื่อผู้ใช้";
    } else {
        $update = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
        $update->execute([$username, $user_id]);

        $msg = "✅ บันทึกข้อมูลสำเร็จแล้ว";
        $user['username'] = $username;
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>โปรไฟล์ผู้ใช้</title>
<style>
    body{
        margin:0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg,#0b1220,#0b1b2a);
        color:white;
    }
    .container{
        width:95%;
        max-width:600px;
        margin:auto;
        padding:30px 0;
    }
    .card{
        background:white;
        color:#0f172a;
        border-radius:18px;
        padding:25px;
        box-shadow:0 10px 30px rgba(0,0,0,0.25);
    }
    input{
        width:100%;
        padding:12px;
        border-radius:12px;
        border:1px solid #e5e7eb;
        margin-top:8px;
        font-size:15px;
    }
    button{
        margin-top:18px;
        width:100%;
        background:#2563eb;
        color:white;
        border:none;
        padding:12px;
        border-radius:12px;
        cursor:pointer;
        font-weight:bold;
        box-shadow:0 6px 15px rgba(37,99,235,0.35);
    }
    .msg{
        margin-top:12px;
        font-weight:bold;
        padding:10px;
        border-radius:12px;
        background:#f1f5f9;
        color:#0f172a;
    }
    a{
        display:inline-block;
        margin-top:15px;
        color:#2563eb;
        text-decoration:none;
        font-weight:bold;
    }
</style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2>👤 โปรไฟล์ของคุณ</h2>

        <form method="post">
            <label>ชื่อผู้ใช้ (Username)</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <button type="submit">💾 บันทึกข้อมูล</button>
        </form>

        <?php if($msg != ""): ?>
            <div class="msg"><?php echo $msg; ?></div>
        <?php endif; ?>

        <a href="index.php">⬅ กลับหน้าแรกผู้ใช้</a>
    </div>
</div>

</body>
</html>
