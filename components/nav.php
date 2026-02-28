<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
?>
<nav>
    <h2>SMS Portal</h2>
    <a href="../Student/student.php">Students</a>
    <a href="../Teacher/teacher.php">Teachers</a>
    <a href="../Course/course.php">Courses</a>
    <a href="../Room/room.php">Rooms</a>
    <a href="../logout.php" style="margin-top: auto; color: #ef4444;">Logout</a>
</nav>
