<?php
// Quick DB test
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=weather_insight;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "DB Connected OK\n";
    
    $r = $pdo->query("SELECT COUNT(*) as c FROM activity_log");
    echo "Activity log rows: " . $r->fetch(PDO::FETCH_ASSOC)['c'] . "\n";
    
    $r = $pdo->query("SELECT COUNT(*) as c FROM users");
    echo "Users rows: " . $r->fetch(PDO::FETCH_ASSOC)['c'] . "\n";
    
    $r = $pdo->query("SELECT COUNT(*) as c FROM user_sessions");
    echo "Sessions rows: " . $r->fetch(PDO::FETCH_ASSOC)['c'] . "\n";
    
    $r = $pdo->query("SELECT id, username, role, email, last_login FROM users");
    echo "\nUsers:\n";
    while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
        echo "  #{$row['id']} {$row['username']} ({$row['role']}) - {$row['email']} - Last login: " . ($row['last_login'] ?? 'never') . "\n";
    }
    
    $r = $pdo->query("SELECT id, user_id, action, description, ip_address, created_at FROM activity_log ORDER BY id DESC LIMIT 5");
    echo "\nRecent Activity:\n";
    while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
        echo "  #{$row['id']} user={$row['user_id']} [{$row['action']}] {$row['description']} ({$row['ip_address']}) @ {$row['created_at']}\n";
    }
    
    // Test INSERT into activity_log
    $stmt = $pdo->prepare("INSERT INTO activity_log (user_id, action, description, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->execute([1, 'test', 'DB test from CLI', '127.0.0.1']);
    echo "\nTest insert OK! ID: " . $pdo->lastInsertId() . "\n";
    
    // Clean up test row
    $pdo->exec("DELETE FROM activity_log WHERE action='test' AND description='DB test from CLI'");
    echo "Test row cleaned up.\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
