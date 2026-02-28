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

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $id = $_POST['stud_id'];
    $name = $_POST['stud_name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $year = $_POST['year'];

    $stmt = $pdo->prepare("INSERT INTO Stud_table (Stud_ID, Stud_name, Age, Sex, Year) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id, $name, $age, $sex, $year]);
    header("Location: student.php?msg=Student registered successfully");
    exit;
}

// Handle Search
$search = $_GET['search'] ?? '';
$query = "SELECT * FROM Stud_table";
if ($search) {
    $query .= " WHERE Stud_ID LIKE ? OR Stud_name LIKE ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute(["%$search%", "%$search%"]);
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
    <title>Student Management - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    
    <main>
        <div class="container">
            <h1>Student Management</h1>
            
            <?php if (isset($_GET['msg'])): ?>
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>

            <div class="form-card" style="margin-bottom: 3rem;">
                <h2>Register New Student</h2>
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
                    <button type="submit" name="register">Register Student</button>
                </form>
            </div>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2>Student Records</h2>
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
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $s): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($s['Stud_ID']); ?></td>
                                <td><?php echo htmlspecialchars($s['Stud_name']); ?></td>
                                <td><?php echo htmlspecialchars($s['Age']); ?></td>
                                <td><?php echo htmlspecialchars($s['Sex']); ?></td>
                                <td><?php echo htmlspecialchars($s['Year']); ?></td>
                                <td>
                                    <a href="?delete=<?php echo urlencode($s['Stud_ID']); ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
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
