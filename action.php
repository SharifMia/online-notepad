<?php
// action.php
require 'db.php';

// নোট সেভ বা আপডেট করার লজিক
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // খালি ইনপুট চেক করা
    if (!empty($title) && !empty($content)) {
        if (!empty($id)) {
            // আপডেট (Update) লজিক
            $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ?");
            $stmt->execute([$title, $content, $id]);
        } else {
            // নতুন সেভ (Create) লজিক
            $stmt = $pdo->prepare("INSERT INTO notes (title, content) VALUES (?, ?)");
            $stmt->execute([$title, $content]);
        }
    }
    header("Location: index.php");
    exit;
}

// নোট ডিলেট করার লজিক
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->execute([$id]);
    
    header("Location: index.php");
    exit;
}
?>
