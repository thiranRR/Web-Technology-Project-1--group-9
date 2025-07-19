<?php
$host = 'localhost';     // MySQL host (don't change)
$db   = 'wtdb';          // Your database name
$user = 'root';          // Default XAMPP username
$pass = '';              // Default XAMPP has no password

try {
    // Create a new PDO (PHP Data Object) connection
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // Set error mode to throw exceptions for debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully!"; // Uncomment to test connection
} catch (PDOException $e) {
    // If connection fails, show an error
    die("Database connection failed: " . $e->getMessage());
}
?>
