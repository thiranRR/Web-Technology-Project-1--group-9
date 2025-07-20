<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current'];
    $newPassword = $_POST['new'];
    $confirmPassword = $_POST['confirm'];

    // Validate input
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo "All fields are required.";
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo "New password and confirmation do not match.";
        exit;
    }

    // Fetch user details from session or database
    $userId = $_SESSION['user_id']; // Assuming user ID is stored in session
    $db = new Database();
    $user = $db->getUserById($userId);

    // Verify current password
    if (!password_verify($currentPassword, $user['password'])) {
        echo "Current password is incorrect.";
        exit;
    }

    // Update password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    if ($db->updatePassword($userId, $hashedPassword)) {
        echo "Password changed successfully.";
    } else {
        echo "Failed to change password. Please try again.";
    }
}
?>

<form method="POST" action="change_password.php">
    <label for="current">Current Password</label>
    <input type="password" id="current" name="current" required>
    
    <label for="new">New Password</label>
    <input type="password" id="new" name="new" required>
    
    <label for="confirm">Confirm New Password</label>
    <input type="password" id="confirm" name="confirm" required>
    
    <button type="submit">Change Password</button>
</form>