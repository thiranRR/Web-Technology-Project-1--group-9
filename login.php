<?php
session_start();
require 'db.php';
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($role === 'student') {
        $stmt = $pdo->prepare("SELECT * FROM student WHERE (student_id = :username OR email = :username) AND password = :password LIMIT 1");
    } elseif ($role === 'lecturer') {
        $stmt = $pdo->prepare("SELECT * FROM faculty_member WHERE (faculty_id = :username OR email = :username) AND password = :password LIMIT 1");
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid login type.']);
        exit;
    }

    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = $user;
        echo json_encode([
            'success' => true,
            'message' => 'Login successful.',
            'role' => $role
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Account not found. Please create an account.'
        ]);
    }
}
?>
