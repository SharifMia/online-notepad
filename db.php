<?php
// db.php
$host = 'localhost';
$db   = 'u130399659_notepad'; 
$user = 'u130399659_notepad';      
$pass = 'Roll:4423@';          

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
?>
