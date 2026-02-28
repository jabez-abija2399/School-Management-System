<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    try {
        $id = $_POST['co_id'];
        $name = $_POST['co_name'];
        $dept = $_POST['department'];

        $stmt = $pdo->prepare("INSERT INTO Course_table (Co_ID, Co_name, department) VALUES (?, ?, ?)");
        $stmt->execute([$id, $name, $dept]);
        header("Location: course.php?msg=Course registered successfully");
        exit;
    } catch (PDOException $e) {
        $error = "Course Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Course - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <h1>Add New Course</h1>
                <a href="course.php" class="btn-primary" style="background-color: #64748b;">
                    <i class="fas fa-arrow-left"></i> Back to Courses
                </a>
            </div>
            <div class="form-card">
                <form method="POST">
                    <div class="form-group">
                        <label>Course ID</label>
                        <input type="text" name="co_id" required placeholder="e.g. C001">
                    </div>
                    <div class="form-group">
                        <label>Course Name</label>
                        <input type="text" name="co_name" required>
                    </div>
                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" name="department" required>
                    </div>
                    <button type="submit" name="register" class="btn-full">Create Course</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
