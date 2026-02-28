<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    try {
        $name = $_POST['dept_name'];
        $prog_id = $_POST['prog_id'];
        $stmt = $pdo->prepare("INSERT INTO Departments_table (Dept_Name, Prog_ID) VALUES (?, ?)");
        $stmt->execute([$name, $prog_id]);
        header("Location: program.php?msg=Department added successfully");
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

$progs = $pdo->query("SELECT * FROM Programs_table")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <h1>Add New Department</h1>
                <a href="program.php" class="btn-primary" style="background: #64748b;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="form-card">
                <form method="POST">
                    <div class="form-group">
                        <label>Select Program</label>
                        <select name="prog_id" required>
                            <?php foreach ($progs as $p): ?>
                                <option value="<?php echo $p['Prog_ID']; ?>"><?php echo htmlspecialchars($p['Prog_Name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Department Name</label>
                        <input type="text" name="dept_name" required placeholder="e.g. Software, Nursing, Accounting">
                    </div>
                    <button type="submit" name="add" class="btn-full">Assign Department</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
