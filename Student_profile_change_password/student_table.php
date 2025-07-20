<?php
require_once 'db.php';

function fetchStudents() {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM students");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$students = fetchStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Table</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link to a CSS file for styling -->
</head>
<body>
    <h1>Student Details</h1>
    <table>
        <thead>
            <tr>
                <th>Matric No.</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Date of Birth</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['matric_no']); ?></td>
                    <td><?php echo htmlspecialchars($student['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($student['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                    <td><?php echo htmlspecialchars($student['date_of_birth']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>