<?php
require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/auth_admin.php";

$success = "";
$error = "";

// เปลี่ยน role
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_role'])) {
    $user_id = (int)($_POST['user_id'] ?? 0);
    $role = $_POST['role'] ?? 'user';

    if ($user_id > 0 && in_array($role, ['user', 'admin'])) {
        $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->execute([$role, $user_id]);
        $success = "อัปเดตสิทธิ์สำเร็จ!";
    } else {
        $error = "ข้อมูลไม่ถูกต้อง";
    }
}

// ลบผู้ใช้
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];

    // กันแอดมินลบตัวเอง
    if ($delete_id === (int)($_SESSION['user_id'] ?? 0)) {
        $error = "คุณไม่สามารถลบบัญชีของตัวเองได้";
    } else {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$delete_id]);
        header("Location: manage_users.php");
        exit;
    }
}

// ดึงข้อมูลผู้ใช้ทั้งหมด
$users = $pdo->query("SELECT id, username, role FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการผู้ใช้งาน</title>
<style>
body{font-family:Arial;background:#f4f6f8;margin:0;padding:20px;}
.box{max-width:900px;margin:auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,.1);}
table{width:100%;border-collapse:collapse;margin-top:15px;}
th,td{border-bottom:1px solid #ddd;padding:10px;text-align:left;}
select,button{padding:6px 10px;}
.btn-del{background:#dc2626;color:#fff;border:none;border-radius:6px;cursor:pointer;}
.btn-del:hover{background:#b91c1c;}
.msg-success{color:green;font-weight:bold;}
.msg-error{color:red;font-weight:bold;}
</style>
</head>
<body>

<div class="box">
    <h2>👥 จัดการผู้ใช้งาน</h2>

    <?php if ($success): ?>
        <p class="msg-success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="msg-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>เปลี่ยนสิทธิ์</th>
            <th>ลบ</th>
        </tr>

        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= (int)$u['id'] ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><b><?= htmlspecialchars($u['role'] ?? 'user') ?></b></td>

                <td>
                    <form method="post" style="display:flex; gap:8px; align-items:center;">
                        <input type="hidden" name="user_id" value="<?= (int)$u['id'] ?>">

                        <select name="role">
                            <option value="user" <?= (($u['role'] ?? '') === 'user') ? 'selected' : '' ?>>user</option>
                            <option value="admin" <?= (($u['role'] ?? '') === 'admin') ? 'selected' : '' ?>>admin</option>
                        </select>

                        <button type="submit" name="change_role">บันทึก</button>
                    </form>
                </td>

                <td>
                    <?php if ((int)$u['id'] !== (int)($_SESSION['user_id'] ?? 0)): ?>
                        <a href="manage_users.php?delete_id=<?= (int)$u['id'] ?>"
                           onclick="return confirm('คุณต้องการลบผู้ใช้นี้ใช่ไหม?');">
                            <button class="btn-del">ลบ</button>
                        </a>
                    <?php else: ?>
                        <span style="color:#888;">(บัญชีคุณ)</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="dashboard.php">⬅ กลับหน้าแอดมิน</a>
</div>

</body>
</html>
