<?php

try {
    $pdo = new PDO('sqlite:var/data.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT * FROM post");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($posts) . " posts:\n";
    foreach ($posts as $post) {
        echo "- " . $post['title'] . " by " . $post['author'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>