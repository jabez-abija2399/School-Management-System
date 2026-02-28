<?php
session_start();
require_once '../config/db.php';

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $id = $_POST['co_id'];
    $name = $_POST['co_name'];
    $dept = $_POST['department'];

    $stmt = $pdo->prepare("INSERT INTO Course_table (Co_ID, Co_name, department) VALUES (?, ?, ?)");
    $stmt->execute([$id, $name, $dept]);
    header("Location: course.php?msg=Course registered successfully");
    exit;
}

$stmt = $pdo->query("SELECT * FROM Course_table");
$courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <h1>Course Management</h1>
            <?php if (isset($_GET['msg'])): ?>
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>
            <div class="form-card" style="margin-bottom: 3rem;">
                <h2>Register New Course</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Course ID</label>
                        <input type="text" name="co_id" required placeholder="e.g. C005">
                    </div>
                    <div class="form-group">
                        <label>Course Name</label>
                        <input type="text" name="co_name" required>
                    </div>
                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" name="department" required>
                    </div>
                    <button type="submit" name="register">Register Course</button>
                </form>
            </div>
            <div class="table-container">
                <h2>Course Records</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($c['Co_ID']); ?></td>
                                <td><?php echo htmlspecialchars($c['Co_name']); ?></td>
                                <td><?php echo htmlspecialchars($c['department']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
