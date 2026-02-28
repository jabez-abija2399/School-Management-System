<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    try {
        $id = $_POST['stud_id'];
        $name = $_POST['stud_name'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $year = $_POST['year'];

        $stmt = $pdo->prepare("INSERT INTO Stud_table (Stud_ID, Stud_name, Age, Sex, Year) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id, $name, $age, $sex, $year]);
        header("Location: student.php?msg=Student registered successfully");
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
    <title>Register Student - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    
    <main>
        <div class="container">
            <div class="page-header">
                <h1>Register New Student</h1>
                <a href="student.php" class="btn-primary" style="background-color: #64748b;">
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
                        <label>Student ID</label>
                        <input type="text" name="stud_id" required placeholder="e.g. S005">
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="stud_name" required>
                    </div>
                    <div style="display: flex; gap: 1rem;">
                        <div class="form-group" style="flex: 1;">
                            <label>Age</label>
                            <input type="number" name="age" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label>Sex</label>
                            <select name="sex" required>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Year</label>
                        <input type="number" name="year" required>
                    </div>
                    <button type="submit" name="register" class="btn-full">Confirm Registration</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
