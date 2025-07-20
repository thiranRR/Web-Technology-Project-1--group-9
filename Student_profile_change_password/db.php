<?php
// Database configuration
$host = 'localhost';
$dbname = 'student_profile_db';
$username = 'root';
$password = '';

// Create a PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

/**
 * Fetch all student details from the database.
 *
 * @return array
 */
function fetchStudents() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM students");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Update the student's password in the database.
 *
 * @param int $studentId
 * @param string $newPassword
 * @return bool
 */
function updatePassword($studentId, $newPassword) {
    global $pdo;
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE students SET password = :password WHERE id = :id");
    return $stmt->execute(['password' => $hashedPassword, 'id' => $studentId]);
}
?>