<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<nav>
    <h2>SMS Portal</h2>
    <a href="../Student/student.php" class="<?php echo ($current_page == 'student.php') ? 'active' : ''; ?>">Students</a>
    <a href="../Teacher/teacher.php" class="<?php echo ($current_page == 'teacher.php') ? 'active' : ''; ?>">Teachers</a>
    <a href="../Course/course.php" class="<?php echo ($current_page == 'course.php') ? 'active' : ''; ?>">Courses</a>
    <a href="../Room/room.php" class="<?php echo ($current_page == 'room.php') ? 'active' : ''; ?>">Rooms</a>
    <a href="../logout.php" style="margin-top: auto; color: #ef4444; border-left: none !important; background: transparent !important;">Logout</a>
</nav>
