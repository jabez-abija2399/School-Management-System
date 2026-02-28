<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    try {
        $id = $_POST['room_id'];
        $bld = $_POST['bld_num'];
        $type = $_POST['room_type'];

        $stmt = $pdo->prepare("INSERT INTO Room_table (Room_ID, Bld_num, Room_type) VALUES (?, ?, ?)");
        $stmt->execute([$id, $bld, $type]);
        header("Location: room.php?msg=Room registered successfully");
        exit;
    } catch (PDOException $e) {
        $error = "Room Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Room - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <h1>Add New Room</h1>
                <a href="room.php" class="btn-primary" style="background-color: #64748b;">
                    <i class="fas fa-arrow-left"></i> Back to Rooms
                </a>
            </div>
            <div class="form-card">
                <form method="POST">
                    <div class="form-group">
                        <label>Room ID</label>
                        <input type="text" name="room_id" required placeholder="e.g. Ro001">
                    </div>
                    <div class="form-group">
                        <label>Building Number</label>
                        <input type="text" name="bld_num" required placeholder="e.g. B-01">
                    </div>
                    <div class="form-group">
                        <label>Room Type</label>
                        <select name="room_type" required>
                            <option value="lab">Laboratory</option>
                            <option value="lecture">Lecture Hall</option>
                            <option value="office">Office</option>
                        </select>
                    </div>
                    <button type="submit" name="register" class="btn-full">Register Room</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
