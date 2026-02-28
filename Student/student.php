<?php
session_start();
require_once '../config/db.php';

// Handle Deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM Stud_table WHERE Stud_ID = ?");
    $stmt->execute([$id]);
    header("Location: student.php?msg=Student deleted successfully");
    exit;
}

// Handle Search
$search = $_GET['search'] ?? '';
$query = "SELECT * FROM Stud_table";
if ($search) {
    $query .= " WHERE Stud_ID LIKE ? OR Stud_name LIKE ? OR Program LIKE ? OR Department LIKE ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute(["%$search%", "%$search%", "%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query($query);
}
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    
    <main>
        <div class="container">
            <div class="page-header">
                <div>
                    <h1>Student Records</h1>
                    <p style="color: #64748b;">Managing academic enrollment</p>
                </div>
                <a href="register_student.php" class="btn-primary">
                    <i class="fas fa-plus"></i> Add New Student
                </a>
            </div>
            
            <?php if (isset($_GET['msg'])): ?>
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <div style="margin-bottom: 2.5rem;">
                    <form method="GET" style="display: flex; gap: 1rem; align-items: center;">
                        <div class="search-wrapper">
                            <input type="text" name="search" class="search-input" placeholder="Search ID, Name, Program..." value="<?php echo htmlspecialchars($search); ?>">
                            <i class="fas fa-search"></i>
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-filter"></i> Search
                        </button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Details</th>
                            <th>Program</th>
                            <th>Department</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 3rem; color: #94a3b8;">No records found.</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($students as $s): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--primary-color); font-family: monospace;"><?php echo htmlspecialchars($s['Stud_ID']); ?></td>
                                <td style="font-weight: 500;"><?php echo htmlspecialchars($s['Stud_name']); ?></td>
                                <td>
                                    <span style="font-size: 0.8rem; color: #64748b;">
                                        Age: <?php echo htmlspecialchars($s['Age']); ?> | <?php echo $s['Sex'] == 'M' ? 'Male' : 'Female'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="padding: 0.25rem 0.6rem; border-radius: 4px; background: #e0f2fe; color: #0369a1; font-size: 0.75rem; font-weight: 700;">
                                        <?php echo htmlspecialchars($s['Program']); ?>
                                    </span>
                                </td>
                                <td style="font-size: 0.9rem; font-weight: 500;"><?php echo htmlspecialchars($s['Department']); ?></td>
                                <td style="text-align: right;">
                                    <a href="?delete=<?php echo urlencode($s['Stud_ID']); ?>" class="btn-delete" onclick="return confirm('Permanent delete student: <?php echo addslashes($s['Stud_name']); ?>?')" title="Delete">
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
