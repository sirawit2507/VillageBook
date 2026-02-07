<?php
session_start();
require 'db.php';

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = "กรุณากรอกข้อมูลให้ครบ";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // ✅ แก้ตรงนี้: PASSWORD (ตัวใหญ่)
        if ($user && isset($user['PASSWORD']) && password_verify($password, $user['PASSWORD'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if (strtolower($user['role']) === 'admin') {
                header("Location: admin/dashboard.php");
                exit;
            } else {
                header("Location: index.php");
                exit;
            }

        } else {
            $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เข้าสู่ระบบ - VillageBook</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="login.css">
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

      <div class="logo"><i class="fa-solid fa-lock"></i></div>

      <div class="login-title">เข้าสู่ระบบ</div>
      <div class="login-subtitle">กรุณาเข้าสู่ระบบเพื่อใช้งาน</div>

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
                   value="<?= htmlspecialchars($username) ?>" required>
          </div>
        </div>

        <div class="form-group">
          <label>รหัสผ่าน</label>

          <div class="input-wrap">
            <i class="fa-solid fa-key input-icon-left"></i>
            <input type="password" name="password" id="password" class="input"
                   placeholder="Password" required>

            <button type="button" class="toggle-pass" onclick="togglePassword()" aria-label="แสดง/ซ่อนรหัสผ่าน">
              <i id="eyeIcon" class="fa-solid fa-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-login">
          <i class="fa-solid fa-right-to-bracket"></i> เข้าสู่ระบบ
        </button>
      </form>

      <div class="bottom-links">
        ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a>
      </div>

    </div>
  </div>

  <script>
    function togglePassword(){
      const pass = document.getElementById("password");
      const icon = document.getElementById("eyeIcon");

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
