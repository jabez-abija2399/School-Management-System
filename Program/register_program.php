<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    try {
        $name = $_POST['prog_name'];
        $stmt = $pdo->prepare("INSERT INTO Programs_table (Prog_Name) VALUES (?)");
        $stmt->execute([$name]);
        header("Location: program.php?msg=Program added successfully");
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Program - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <h1>Add New Program</h1>
                <a href="program.php" class="btn-primary" style="background: #64748b;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="form-card">
                <form method="POST">
                    <div class="form-group">
                        <label>Program Name</label>
                        <input type="text" name="prog_name" required placeholder="e.g. TVET, Bachelor, Doctorate">
                    </div>
                    <button type="submit" name="add" class="btn-full">Create Program</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
