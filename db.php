<?php
// db.php
$host = 'localhost';
$db   = 'u130399659_notepad'; 
$user = 'u130399659_notepad';      
$pass = 'Roll:4423@';          

// Enable MySQLi exceptions for better error handling (similar to PDO's ERRMODE_EXCEPTION)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create MySQLi connection
    $conn = new mysqli($host, $user, $pass, $db);
    
    // Set charset to utf8mb4 (Optimized to support emojis and complex characters)
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    // Hide exact errors from users, show a generic message
    die("Database Connection failed: " . $e->getMessage());
}
?>
