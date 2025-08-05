<?php


try {
    $pdo = new PDO('sqlite:var/data.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $posts = [
        ['Welcome to Mini Blog', 'This is our first blog post! Welcome to our new mini blog platform built with Symfony and jQuery.', 'Admin'],
        ['Symfony Tips', 'Here are some useful Symfony development tips that every developer should know...', 'Developer'],
        ['AJAX Best Practices', 'When working with AJAX requests, always remember to handle errors properly and provide user feedback.', 'Frontend Expert']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO post (title, content, author, created_at, updated_at) VALUES (?, ?, ?, datetime('now'), datetime('now'))");
    
    foreach ($posts as $post) {
        $stmt->execute($post);
        echo "Inserted: " . $post[0] . "\n";
    }
    
    echo "Test data added successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>