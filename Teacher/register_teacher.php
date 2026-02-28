<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    try {
        $id = $_POST['t_id'];
        $name = $_POST['t_name'];
        $major = $_POST['major'];

        $stmt = $pdo->prepare("INSERT INTO Teach_table (T_Id, T_name, Major) VALUES (?, ?, ?)");
        $stmt->execute([$id, $name, $major]);
        header("Location: teacher.php?msg=Teacher registered successfully");
        exit;
    } catch (PDOException $e) {
        $error = "Registration Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Teacher - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <h1>Register New Teacher</h1>
                <a href="teacher.php" class="btn-primary" style="background-color: #64748b;">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
            <?php if (isset($error)): ?>
                <div style="background: var(--danger); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <div class="form-card">
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
                        <input type="text" name="major" required placeholder="e.g. Mathematics">
                    </div>
                    <button type="submit" name="register" class="btn-full">Confirm Teacher Registration</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
