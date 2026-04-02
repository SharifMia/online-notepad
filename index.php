<?php
// index.php
require 'db.php';

// If 'Edit' button is clicked, fetch the specific note data to populate the form
$edit_note = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM notes WHERE id = ?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $edit_note = $result->fetch_assoc();
    }
    $stmt->close();
}

// Fetch all notes from the database (Newest first)
$sql = "SELECT * FROM notes ORDER BY created_at DESC";
$result = $conn->query($sql);

$notes = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Online Notepad</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📝 My Notes</h1>
            <p>Simple & Secure PHP Notepad</p>
        </header>

        <div class="form-container">
            <form action="action.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($edit_note['id'] ?? '') ?>">
                
                <input type="text" name="title" placeholder="Note Title..." 
                       value="<?= htmlspecialchars($edit_note['title'] ?? '') ?>" required>
                
                <textarea name="content" rows="4" placeholder="Write your note here..." required><?= htmlspecialchars($edit_note['content'] ?? '') ?></textarea>
                
                <div class="form-actions">
                    <button type="submit" name="save" class="btn-save">
                        <?= $edit_note ? '💾 Update Note' : '➕ Add Note' ?>
                    </button>
                    
                    <?php if($edit_note): ?>
                        <a href="index.php" class="btn-cancel">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="notes-grid">
            <?php if(count($notes) > 0): ?>
                <?php foreach ($notes as $note): ?>
                    <div class="note-card">
                        <h3><?= htmlspecialchars($note['title']) ?></h3>
                        <p class="content"><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                        <div class="note-footer">
                            <small class="date">📅 <?= date('d M, Y - h:i A', strtotime($note['created_at'])) ?></small>
                            <div class="actions">
                                <a href="index.php?edit=<?= $note['id'] ?>" class="btn-edit">✏️ Edit</a>
                                <a href="action.php?delete=<?= $note['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this note?');">🗑️ Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-state">No notes found. Create your first note!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
