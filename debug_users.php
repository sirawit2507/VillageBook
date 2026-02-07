<?php
require 'db.php';

echo "<h1>User List Debug</h1>";
echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Password (First 60 chars)</th><th>Role</th></tr>";

$stmt = $pdo->query("SELECT * FROM users");
while ($row = $stmt->fetch()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
    echo "<td>" . htmlspecialchars(substr($row['password'], 0, 60)) . "...</td>"; // Truncate for safety/display
    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
