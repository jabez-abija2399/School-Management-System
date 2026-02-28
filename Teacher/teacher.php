<?php
session_start();
require_once '../config/db.php';

// Handle Search
$search = $_GET['search'] ?? '';
$query = "SELECT * FROM Teach_table";
if ($search) {
    $query .= " WHERE T_Id LIKE ? OR T_name LIKE ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query($query);
}
$teachers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <div>
                    <h1>Teacher Directory</h1>
                    <p style="color: #64748b;">View and manage faculty members</p>
                </div>
                <a href="register_teacher.php" class="btn-primary">
                    <i class="fas fa-plus"></i> Add New Teacher
                </a>
            </div>
            
            <?php if (isset($_GET['msg'])): ?>
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <div style="margin-bottom: 2.5rem;">
                    <form method="GET" style="display: flex; gap: 1rem; align-items: center;">
                        <div class="search-wrapper">
                            <input type="text" name="search" class="search-input" placeholder="Search by ID or Name..." value="<?php echo htmlspecialchars($search); ?>">
                            <i class="fas fa-search"></i>
                        </div>
                        <button type="submit" class="btn-primary" style="padding: 0.875rem 1.5rem;">
                             <i class="fas fa-filter"></i> Find Teacher
                        </button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Major</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teachers as $t): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--primary-color);">#<?php echo htmlspecialchars($t['T_Id']); ?></td>
                                <td style="font-weight: 500;"><?php echo htmlspecialchars($t['T_name']); ?></td>
                                <td><?php echo htmlspecialchars($t['Major']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
