<?php

try {
    $pdo = new PDO('sqlite:var/data.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "
    CREATE TABLE IF NOT EXISTS post (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        author VARCHAR(255) NOT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL
    )";
    
    $pdo->exec($sql);
    echo "Table 'post' created successfully!\n";
    
    $result = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='post'");
    if ($result->fetch()) {
        echo "Table 'post' exists and is ready to use.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>