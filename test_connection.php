
<?php
require 'conn.php';

try {
    $stmt = $pdo->query('SELECT 1');
    if ($stmt) {
        echo "Database connection successful!";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
