<?php
// action.php
require 'db.php';

// Logic for Saving or Updating a Note
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Check for empty inputs
    if (!empty($title) && !empty($content)) {
        if (!empty($id)) {
            // Update Logic (Using MySQLi Prepared Statement)
            $stmt = $conn->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ?");
            // "ssi" means: String, String, Integer
            $stmt->bind_param("ssi", $title, $content, $id);
            $stmt->execute();
            $stmt->close();
        } else {
            // Create New Logic (Using MySQLi Prepared Statement)
            $stmt = $conn->prepare("INSERT INTO notes (title, content) VALUES (?, ?)");
            // "ss" means: String, String
            $stmt->bind_param("ss", $title, $content);
            $stmt->execute();
            $stmt->close();
        }
    }
    // Redirect back to home
    header("Location: index.php");
    exit;
}

// Logic for Deleting a Note
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    // "i" means: Integer
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    
    // Redirect back to home
    header("Location: index.php");
    exit;
}
?>
