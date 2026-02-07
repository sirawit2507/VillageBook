<?php
require '../db.php';
session_start();

$id = $_GET['id'] ?? null;
$status = $_GET['status'] ?? null;

if ($id && in_array($status, ['approved', 'rejected'])) {
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

header("Location: admin_bookings.php");
exit;
