<?php
require 'db.php';

$newPassword = password_hash('123456', PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE users SET PASSWORD = ? WHERE username = ?");
$stmt->execute([$newPassword, 'yas123']);

echo "OK";
