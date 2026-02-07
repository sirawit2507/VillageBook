<?php
require 'db.php';

try {
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Columns in 'users' table: " . implode(", ", $columns) . "\n";
    
    // Also show full details case-sensitive
    $stmt = $pdo->query("SELECT * FROM users LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "Sample row keys: " . implode(", ", array_keys($row));
    } else {
        echo "Table is empty.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
