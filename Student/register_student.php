<?php
session_start();
require_once '../config/db.php';

// Fetch Programs and Departments for JavaScript
$all_progs = $pdo->query("SELECT * FROM Programs_table")->fetchAll(PDO::FETCH_ASSOC);
$all_depts = $pdo->query("SELECT * FROM Departments_table")->fetchAll(PDO::FETCH_ASSOC);

function generateStudentID($pdo, $programName, $deptName) {
    $year = date('y'); 
    $progCode = strtoupper(substr($programName, 0, 3));
    
    // Mapping for clean Dept codes
    $deptCodes = [
        'Hardware' => 'HW',
        'Software' => 'SW',
        'Computer Science' => 'CS',
        'Information Technology' => 'IT',
        'Software Engineering' => 'SE',
        'Masters in IT' => 'MIT',
        'MBA' => 'MBA'
    ];
    $deptCode = $deptCodes[$deptName] ?? strtoupper(substr($deptName, 0, 2));
    
    $prefix = "$progCode-$deptCode-$year-";
    
    // Find highest sequence
    $stmt = $pdo->prepare("SELECT Stud_ID FROM Stud_table WHERE Stud_ID LIKE ? ORDER BY Stud_ID DESC LIMIT 1");
    $stmt->execute([$prefix . '%']);
    $lastId = $stmt->fetchColumn();
    
    $seq = 1;
    if ($lastId) {
        $parts = explode('-', $lastId);
        $seq = intval(end($parts)) + 1;
    }
    
    return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    try {
        $name = $_POST['stud_name'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $program = $_POST['program'];
        $dept = $_POST['department'];
        
        $id = generateStudentID($pdo, $program, $dept);

        $stmt = $pdo->prepare("INSERT INTO Stud_table (Stud_ID, Stud_name, Age, Sex, Program, Department) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id, $name, $age, $sex, $program, $dept]);
        
        header("Location: student.php?msg=Student registered! ID: " . $id);
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
                <div>
                    <h1>Register Student</h1>
                    <p style="color: #64748b;">Dynamic program & department selection</p>
                </div>
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
                        <label>Full Name</label>
                        <input type="text" name="stud_name" required placeholder="Enter full name">
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
                        <label>Select Program</label>
                        <select name="program" id="program" required onchange="updateDepartments()">
                            <option value="">-- Choose Program --</option>
                            <?php foreach ($all_progs as $p): ?>
                                <option value="<?php echo htmlspecialchars($p['Prog_Name']); ?>"><?php echo htmlspecialchars($p['Prog_Name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Academic Department</label>
                        <select name="department" id="department" required disabled>
                            <option value="">-- Select Program First --</option>
                        </select>
                    </div>

                    <button type="submit" name="register" class="btn-full">
                        <i class="fas fa-id-card"></i> Finalize & Generate ID
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        const departmentsByProgram = {};
        <?php foreach ($all_progs as $p): ?>
            departmentsByProgram['<?php echo addslashes($p['Prog_Name']); ?>'] = [
                <?php 
                $filtered_depts = array_filter($all_depts, function($d) use ($p) {
                    return $d['Prog_ID'] == $p['Prog_ID'];
                });
                foreach ($filtered_depts as $fd) {
                    echo "'" . addslashes($fd['Dept_Name']) . "',";
                }
                ?>
            ];
        <?php endforeach; ?>

        function updateDepartments() {
            const programSelect = document.getElementById('program');
            const deptSelect = document.getElementById('department');
            const selectedProgram = programSelect.value;

            deptSelect.innerHTML = '<option value="">-- Choose Department --</option>';
            
            if (selectedProgram && departmentsByProgram[selectedProgram]) {
                deptSelect.disabled = false;
                departmentsByProgram[selectedProgram].forEach(dept => {
                    const option = document.createElement('option');
                    option.value = dept;
                    option.textContent = dept;
                    deptSelect.appendChild(option);
                });
            } else {
                deptSelect.disabled = true;
                deptSelect.innerHTML = '<option value="">-- Select Program First --</option>';
            }
        }
    </script>
</body>
</html>
