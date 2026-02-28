<?php
session_start();
require_once '../config/db.php';

// Professional JOIN query
$stmt = $pdo->query("
    SELECT c.*, d.Dept_Name 
    FROM Course_table c
    LEFT JOIN Departments_table d ON c.Dept_ID = d.Dept_ID
");
$courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - SMS Admin</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <div>
                    <h1>Professional Course Management</h1>
                    <p style="color: #64748b;">Curated curriculum mapped to academic departments</p>
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
                            <th>Academic Department</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td style="font-weight: 700; color: var(--primary-color);">
                                    <span style="background: rgba(79, 70, 229, 0.1); padding: 0.25rem 0.5rem; border-radius: 0.5rem;">
                                        <?php echo htmlspecialchars($c['Co_ID']); ?>
                                    </span>
                                </td>
                                <td style="font-weight: 600;"><?php echo htmlspecialchars($c['Co_name']); ?></td>
                                <td>
                                    <span style="display: inline-flex; align-items: center; gap: 0.5rem; color: #475569; font-weight: 500;">
                                        <i class="fas fa-building" style="font-size: 0.8rem; color: #94a3b8;"></i>
                                        <?php echo htmlspecialchars($c['Dept_Name'] ?? 'No Department'); ?>
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <a href="#" class="btn-delete" title="Remove Course">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
