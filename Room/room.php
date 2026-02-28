<?php
session_start();
require_once '../config/db.php';

$stmt = $pdo->query("SELECT * FROM Room_table");
$rooms = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms - SMS</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    <main>
        <div class="container">
            <div class="page-header">
                <div>
                    <h1>Room Inventory</h1>
                    <p style="color: #64748b;">Manage campus facilities</p>
                </div>
                <a href="register_room.php" class="btn-primary">
                    <i class="fas fa-plus"></i> Add New Room
                </a>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Room ID</th>
                            <th>Building</th>
                            <th>Room Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rooms as $r): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--primary-color);"><?php echo htmlspecialchars($r['Room_ID']); ?></td>
                                <td style="font-weight: 500; font-family: monospace;"><?php echo htmlspecialchars($r['Bld_num']); ?></td>
                                <td>
                                    <span style="text-transform: capitalize; padding: 0.25rem 0.6rem; border-radius: 99px; background: #e0f2fe; color: #0369a1; font-size: 0.75rem; font-weight: 600;">
                                        <?php echo htmlspecialchars($r['Room_type']); ?>
                                    </span>
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
