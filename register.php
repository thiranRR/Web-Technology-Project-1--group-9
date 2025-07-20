<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = "localhost";
$username = "root";
$password = "mysql123";
$dbname = "wtdb";

// Connect to MySQL
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $academic_year = $conn->real_escape_string($_POST['academic_year']);
    $faculty = $conn->real_escape_string($_POST['faculty']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

    // Validate password match
    if ($password !== $confirm_password) {
        die("❌ Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into student table
    $sql = "INSERT INTO student (student_id, full_name, email, academic_year, faculty, password)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $student_id, $full_name, $email, $academic_year, $faculty, $hashed_password);

    if ($stmt->execute()) {
        echo "✅ Registration successful!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
