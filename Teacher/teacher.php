<?php
session_start();
require_once '../config/db.php';

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $id = $_POST['t_id'];
    $name = $_POST['t_name'];
    $major = $_POST['major'];

    $stmt = $pdo->prepare("INSERT INTO Teach_table (T_Id, T_name, Major) VALUES (?, ?, ?)");
    $stmt->execute([$id, $name, $major]);
    header("Location: teacher.php?msg=Teacher registered successfully");
    exit;
}

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
    <title>Teacher Management - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    
    <main>
        <div class="container">
            <h1>Teacher Management</h1>
            
            <?php if (isset($_GET['msg'])): ?>
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>

            <div class="form-card" style="margin-bottom: 3rem;">
                <h2>Register New Teacher</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Teacher ID</label>
                        <input type="text" name="t_id" required placeholder="e.g. T005">
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="t_name" required>
                    </div>
                    <div class="form-group">
                        <label>Major</label>
                        <input type="text" name="major" required placeholder="e.g. Computer Science">
                    </div>
                    <button type="submit" name="register">Register Teacher</button>
                </form>
            </div>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2>Teacher Records</h2>
                    <form method="GET" style="display: flex; gap: 0.5rem;">
                        <input type="text" name="search" placeholder="Search by ID or Name" value="<?php echo htmlspecialchars($search); ?>" style="padding: 0.5rem; border-radius: 0.5rem; border: 1px solid #ccc;">
                        <button type="submit" style="width: auto; padding: 0.5rem 1rem;">Search</button>
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
                                <td><?php echo htmlspecialchars($t['T_Id']); ?></td>
                                <td><?php echo htmlspecialchars($t['T_name']); ?></td>
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
