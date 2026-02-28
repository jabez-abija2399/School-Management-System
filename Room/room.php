<?php
session_start();
require_once '../config/db.php';

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $id = $_POST['room_id'];
    $bld = $_POST['bld_num'];
    $type = $_POST['room_type'];

    $stmt = $pdo->prepare("INSERT INTO Room_table (Room_ID, Bld_num, Room_type) VALUES (?, ?, ?)");
    $stmt->execute([$id, $bld, $type]);
    header("Location: room.php?msg=Room registered successfully");
    exit;
}

$stmt = $pdo->query("SELECT * FROM Room_table");
$rooms = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <h1>Room Management</h1>
            <?php if (isset($_GET['msg'])): ?>
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>
            <div class="form-card" style="margin-bottom: 3rem;">
                <h2>Register New Room</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Room ID</label>
                        <input type="text" name="room_id" required placeholder="e.g. Ro6">
                    </div>
                    <div class="form-group">
                        <label>Building Number</label>
                        <input type="text" name="bld_num" required placeholder="e.g. B004">
                    </div>
                    <div class="form-group">
                        <label>Room Type</label>
                        <select name="room_type" required>
                            <option value="lab">Lab</option>
                            <option value="lecture">Lecture</option>
                            <option value="office">Office</option>
                        </select>
                    </div>
                    <button type="submit" name="register">Register Room</button>
                </form>
            </div>
            <div class="table-container">
                <h2>Room Records</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Room ID</th>
                            <th>Building</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rooms as $r): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($r['Room_ID']); ?></td>
                                <td><?php echo htmlspecialchars($r['Bld_num']); ?></td>
                                <td><?php echo htmlspecialchars($r['Room_type']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
