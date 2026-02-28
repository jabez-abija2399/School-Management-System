<?php
session_start();
require_once '../config/db.php';

$stmt = $pdo->query("SELECT * FROM Course_table");
$courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <div>
                    <h1>Available Courses</h1>
                    <p style="color: #64748b;">Browse school curriculum</p>
                </div>
                <a href="register_course.php" class="btn-primary">
                    <i class="fas fa-plus"></i> Add New Course
                </a>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course Name</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--primary-color);"><?php echo htmlspecialchars($c['Co_ID']); ?></td>
                                <td style="font-weight: 500;"><?php echo htmlspecialchars($c['Co_name']); ?></td>
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
