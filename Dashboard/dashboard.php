<?php
session_start();
require_once '../config/db.php';

// Check Login
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

// Analytics Logic
// 1. Total Stats
$totalStudents = $pdo->query("SELECT COUNT(*) FROM Stud_table")->fetchColumn();
$totalTeachers = $pdo->query("SELECT COUNT(*) FROM Teach_table")->fetchColumn();
$totalPrograms = $pdo->query("SELECT COUNT(*) FROM Programs_table")->fetchColumn();
$totalRooms = $pdo->query("SELECT COUNT(*) FROM Room_table")->fetchColumn();

// 2. Program Distribution (for chart)
$progData = $pdo->query("SELECT Program, COUNT(*) as count FROM Stud_table GROUP BY Program")->fetchAll(PDO::FETCH_ASSOC);
$displayPrograms = ['TVET' => 0, 'Bachelor' => 0, 'Postgrad' => 0];
foreach($progData as $row) {
    if (isset($displayPrograms[$row['Program']])) {
        $displayPrograms[$row['Program']] = $row['count'];
    }
}

// 3. Recent Activity (Last 5 students)
$recentStudents = $pdo->query("SELECT Stud_name, Program, Stud_ID, Department FROM Stud_table ORDER BY Stud_ID DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Dashboard - SMS Admin</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../components/nav.php'; ?>
    
    <main>
        <div class="container">
            <div class="page-header">
                <div>
                    <h1 style="font-size: 2.25rem; letter-spacing: -0.025em;">Executive Overview</h1>
                    <p style="color: #64748b; font-size: 1rem; font-weight: 500;">Welcome back, <span style="color: var(--primary-color); font-weight: 700;"><?php echo htmlspecialchars($_SESSION['user']); ?></span>. System is performing optimally.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary-color);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo number_format($totalStudents); ?></div>
                        <div class="stat-label">Students</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo number_format($totalTeachers); ?></div>
                        <div class="stat-label">Faculties</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo number_format($totalPrograms); ?></div>
                        <div class="stat-label">Programs</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo number_format($totalRooms); ?></div>
                        <div class="stat-label">Facilities</div>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 2.5rem; margin-top: 1rem;">
                <!-- Analytics Chart -->
                <div class="chart-container">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-color);">Enrollment Distribution</h3>
                            <p style="font-size: 0.875rem; color: #64748b; font-weight: 500;">Population across academic stages</p>
                        </div>
                        <div style="padding: 0.5rem; background: #f8fafc; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                            <i class="fas fa-chart-bar" style="color: #64748b;"></i>
                        </div>
                    </div>
                    
                    <div class="bar-chart">
                        <?php 
                        $maxCount = max(array_values($displayPrograms)) ?: 1;
                        foreach($displayPrograms as $label => $count): 
                            $height = ($count / $maxCount) * 100;
                        ?>
                        <div class="bar-group">
                            <div class="bar" style="height: <?php echo max($height, 8); ?>%;" data-value="<?php echo $count; ?>"></div>
                            <div class="bar-label"><?php echo $label; ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Recent Registrations -->
                <div class="activity-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-color);">Recent Activity</h3>
                        <a href="../Student/student.php" style="font-size: 0.75rem; font-weight: 700; color: var(--primary-color); text-transform: uppercase; text-decoration: none; letter-spacing: 0.05em; background: rgba(79, 70, 229, 0.05); padding: 0.4rem 0.8rem; border-radius: 2rem;">
                            View All <i class="fas fa-chevron-right" style="font-size: 0.6rem; margin-left: 2px;"></i>
                        </a>
                    </div>
                    
                    <div class="activity-list" style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <?php if (empty($recentStudents)): ?>
                            <div style="text-align: center; padding: 3rem 0; color: #94a3b8;">
                                <i class="fas fa-inbox" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                                <p style="font-weight: 500;">No recent students found</p>
                            </div>
                        <?php endif; ?>
                        
                        <?php foreach($recentStudents as $rs): ?>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-details">
                                <div class="activity-name"><?php echo htmlspecialchars($rs['Stud_name']); ?></div>
                                <div class="activity-meta">Joined <span style="font-weight: 600; color: #475569;"><?php echo htmlspecialchars($rs['Department']); ?></span></div>
                            </div>
                            <div class="activity-id">
                                <?php echo htmlspecialchars($rs['Stud_ID']); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
