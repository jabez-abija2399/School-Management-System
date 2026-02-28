<?php
session_start();
require_once '../config/db.php';

// Fetch departments for dropdown
$deptStmt = $pdo->query("SELECT * FROM Departments_table ORDER BY Dept_Name");
$departments = $deptStmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    try {
        $id = $_POST['co_id'];
        $name = $_POST['co_name'];
        $dept_id = $_POST['dept_id'];

        $stmt = $pdo->prepare("INSERT INTO Course_table (Co_ID, Co_name, Dept_ID) VALUES (?, ?, ?)");
        $stmt->execute([$id, $name, $dept_id]);
        header("Location: course.php?msg=Course registered successfully");
        exit;
    } catch (PDOException $e) {
        $error = "Course Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Course - SMS Admin</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <div>
                    <h1>Modern Course Enrollment</h1>
                    <p style="color: #64748b;">Add new academic programs to the system</p>
                </div>
                <a href="course.php" class="btn-primary" style="background-color: #64748b;">
                    <i class="fas fa-arrow-left"></i> Back to Courses
                </a>
            </div>
            
            <div class="form-card">
                <?php if (isset($error)): ?>
                    <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label>Course Identification</label>
                        <input type="text" name="co_id" required placeholder="e.g. CS-101" style="text-transform: uppercase;">
                    </div>
                    <div class="form-group">
                        <label>Official Course Name</label>
                        <input type="text" name="co_name" required placeholder="e.g. Advanced Database Systems">
                    </div>
                    <div class="form-group">
                        <label>Responsible Academic Department</label>
                        <select name="dept_id" required>
                            <option value="">Select Department...</option>
                            <?php foreach ($departments as $d): ?>
                                <option value="<?php echo $d['Dept_ID']; ?>">
                                    <?php echo htmlspecialchars($d['Dept_Name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="register" class="btn-full">
                        <i class="fas fa-save"></i> Register Course
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
