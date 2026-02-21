<?php
session_start();
require 'db.php';

$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    $stmt = $pdo->prepare("INSERT INTO contacts (name,email,message) VALUES (?,?,?)");
    $stmt->execute([$name,$email,$message]);

    $success = "ส่งข้อความเรียบร้อยแล้ว";
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ติดต่อเรา - VillageBook</title>
<link rel="stylesheet" href="contact.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- ✅ แก้ตรงนี้ -->
<a href="index.php" class="home-float">🏠</a>

<div class="contact-container">

<h2>📞 ติดต่อเรา</h2>

<?php if($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>

<form method="POST" class="contact-form">

    <div>
        <label>ชื่อ</label>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>อีเมล</label>
        <input type="email" name="email" required>
    </div>

    <div class="full">
        <label>ข้อความ</label>
        <textarea name="message" required></textarea>
    </div>

    <button type="submit" class="btn-send">📨 ส่งข้อความ</button>
</form>

</div>

</body>
</html>