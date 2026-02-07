<?php
session_start();
require 'db.php';

$error = '';
$success = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm_password'] ?? '');

    if ($username === '' || $password === '' || $confirm === '') {
        $error = "กรุณากรอกข้อมูลให้ครบ";
    } elseif ($password !== $confirm) {
        $error = "รหัสผ่านไม่ตรงกัน";
    } else {

        // เช็ค username ซ้ำ
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $exists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            $error = "ชื่อผู้ใช้นี้ถูกใช้แล้ว";
        } else {

            // เข้ารหัสรหัสผ่าน
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // *** สำคัญ: คอลัมน์ใน DB ของคุณเป็น PASSWORD (ตัวใหญ่) ***
            $stmt = $pdo->prepare("INSERT INTO users (username, PASSWORD, role) VALUES (?, ?, 'user')");
            $stmt->execute([$username, $hash]);

            // สมัครสำเร็จ -> redirect ไป login (กัน Confirm Form Resubmission)
            $_SESSION['register_success'] = "สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ";
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สมัครสมาชิก - VillageBook</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="register.css">
</head>

<body>

  <div class="bg-grid"></div>
  <div class="scanline"></div>

  <div class="sparkles">
    <i style="top:20%;left:15%"></i>
    <i style="top:30%;left:70%"></i>
    <i style="top:55%;left:25%"></i>
    <i style="top:65%;left:80%"></i>
    <i style="top:15%;left:85%"></i>
    <i style="top:75%;left:45%"></i>
  </div>

  <div class="login-card">
    <div class="login-inner">

      <div class="top-glow"></div>

      <div class="logo"><i class="fa-solid fa-user-plus"></i></div>

      <div class="login-title">สมัครสมาชิก</div>
      <div class="login-subtitle">สร้างบัญชีใหม่เพื่อใช้งานระบบ</div>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
          <i class="fa-solid fa-circle-exclamation"></i>
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="post">

        <div class="form-group">
          <label>ชื่อผู้ใช้</label>
          <div class="input-wrap">
            <i class="fa-solid fa-user input-icon-left"></i>
            <input type="text" name="username" class="input"
                   placeholder="Username"
                   value="<?= htmlspecialchars($username) ?>"
                   required>
          </div>
        </div>

        <div class="form-group">
          <label>รหัสผ่าน</label>
          <div class="input-wrap">
            <i class="fa-solid fa-key input-icon-left"></i>
            <input type="password" name="password" id="password" class="input"
                   placeholder="Password" required>

            <button type="button" class="toggle-pass" onclick="togglePassword('password','eyeIcon1')">
              <i id="eyeIcon1" class="fa-solid fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="form-group">
          <label>ยืนยันรหัสผ่าน</label>
          <div class="input-wrap">
            <i class="fa-solid fa-lock input-icon-left"></i>
            <input type="password" name="confirm_password" id="confirm_password" class="input"
                   placeholder="Confirm Password" required>

            <button type="button" class="toggle-pass" onclick="togglePassword('confirm_password','eyeIcon2')">
              <i id="eyeIcon2" class="fa-solid fa-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-login">
          <i class="fa-solid fa-user-plus"></i> สมัครสมาชิก
        </button>
      </form>

      <div class="bottom-links">
        มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a>
      </div>

    </div>
  </div>

  <script>
    function togglePassword(inputId, iconId){
      const pass = document.getElementById(inputId);
      const icon = document.getElementById(iconId);

      if(pass.type === "password"){
        pass.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      }else{
        pass.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>

</body>
</html>
