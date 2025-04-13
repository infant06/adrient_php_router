<?php
// Database configuration
$host = 'localhost';
$dbname = 'sansia';
$db_username = 'root';
$db_password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$conn = $pdo; // Alias $pdo as $conn for consistency

// Define AES encryption key
define('AES_KEY', 'YourKey');
?>