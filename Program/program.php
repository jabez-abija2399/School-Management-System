<?php
session_start();
require_once '../config/db.php';

// Handle Deletion of Program
if (isset($_GET['delete_prog'])) {
    $id = $_GET['delete_prog'];
    $stmt = $pdo->prepare("DELETE FROM Programs_table WHERE Prog_ID = ?");
    $stmt->execute([$id]);
    header("Location: program.php?msg=Program deleted");
    exit;
}

// Handle Deletion of Department
if (isset($_GET['delete_dept'])) {
    $id = $_GET['delete_dept'];
    $stmt = $pdo->prepare("DELETE FROM Departments_table WHERE Dept_ID = ?");
    $stmt->execute([$id]);
    header("Location: program.php?msg=Department deleted");
    exit;
}

$progs = $pdo->query("SELECT * FROM Programs_table")->fetchAll();
$depts = $pdo->query("SELECT d.*, p.Prog_Name FROM Departments_table d JOIN Programs_table p ON d.Prog_ID = p.Prog_ID")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Structure - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <div>
                    <h1>Academic Structure</h1>
                    <p style="color: #64748b;">Manage programs and departments</p>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <a href="register_program.php" class="btn-primary" style="background: #6366f1;">
                        <i class="fas fa-plus"></i> Add Program
                    </a>
                    <a href="register_dept.php" class="btn-primary">
                        <i class="fas fa-plus"></i> Add Department
                    </a>
                </div>
            </div>

            <?php if (isset($_GET['msg'])): ?>
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <!-- Programs Table -->
                <div class="table-container">
                    <h3>Available Programs</h3>
                    <table style="margin-top: 1rem;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Program Name</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($progs as $p): ?>
                                <tr>
                                    <td>#<?php echo $p['Prog_ID']; ?></td>
                                    <td style="font-weight: 600;"><?php echo htmlspecialchars($p['Prog_Name']); ?></td>
                                    <td style="text-align: right;">
                                        <a href="?delete_prog=<?php echo $p['Prog_ID']; ?>" class="btn-delete" onclick="return confirm('Delete this program and all its departments?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Departments Table -->
                <div class="table-container">
                    <h3>Departments</h3>
                    <table style="margin-top: 1rem;">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Program</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($depts as $d): ?>
                                <tr>
                                    <td style="font-weight: 500;"><?php echo htmlspecialchars($d['Dept_Name']); ?></td>
                                    <td>
                                        <span style="padding: 0.25rem 0.5rem; background: #f1f5f9; border-radius: 4px; font-size: 0.75rem;">
                                            <?php echo htmlspecialchars($d['Prog_Name']); ?>
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="?delete_dept=<?php echo $d['Dept_ID']; ?>" class="btn-delete" onclick="return confirm('Delete this department?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
