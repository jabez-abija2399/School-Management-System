<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
$current_page = basename($_SERVER['SCRIPT_NAME']);
$user_initial = strtoupper(substr($_SESSION['user'], 0, 1));
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Mobile Header -->
<div class="mobile-header">
    <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 800;">
        <i class="fas fa-school" style="color: var(--primary-color);"></i> SMS Admin
    </div>
    <button class="menu-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
</div>

<!-- Overlay for Mobile -->
<div class="sidebar-overlay" id="overlay"></div>

<nav id="sidebar">
    <h2><i class="fas fa-school"></i> SMS Admin</h2>
    
    <div class="nav-label">Management</div>
    <a href="../Student/student.php" class="<?php echo ($current_page == 'student.php' || $current_page == 'register_student.php') ? 'active' : ''; ?>">
        <i class="fas fa-user-graduate"></i> Students
    </a>
    <a href="../Teacher/teacher.php" class="<?php echo ($current_page == 'teacher.php' || $current_page == 'register_teacher.php') ? 'active' : ''; ?>">
        <i class="fas fa-chalkboard-teacher"></i> Teachers
    </a>
    <a href="../Course/course.php" class="<?php echo ($current_page == 'course.php' || $current_page == 'register_course.php') ? 'active' : ''; ?>">
        <i class="fas fa-book"></i> Courses
    </a>
    <a href="../Room/room.php" class="<?php echo ($current_page == 'room.php' || $current_page == 'register_room.php') ? 'active' : ''; ?>">
        <i class="fas fa-door-open"></i> Rooms
    </a>
    <a href="../Program/program.php" class="<?php echo ($current_page == 'program.php' || $current_page == 'register_program.php' || $current_page == 'register_dept.php') ? 'active' : ''; ?>">
        <i class="fas fa-graduation-cap"></i> Programs
    </a>

    <div class="nav-label">System</div>
    <a href="../logout.php" style="color: #ef4444;">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>

    <div class="nav-user">
        <div class="user-avatar"><?php echo $user_initial; ?></div>
        <div class="user-info">
            <div class="user-name"><?php echo htmlspecialchars($_SESSION['user']); ?></div>
            <div class="user-role">Administrator</div>
        </div>
    </div>
</nav>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('overlay');

    if(toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });
    }

    if(overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }
</script>
