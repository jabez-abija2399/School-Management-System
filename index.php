<?php
session_start();
require_once 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = $_POST['account'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM Login_table WHERE Account = ? AND Password = ?");
    $stmt->execute([$account, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user'] = $user['Account'];
        header("Location: Student/student.php");
        exit;
    } else {
        $error = "Invalid account or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Management System</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body class="login-body">
    <div class="login-card">
        <h1>SMS Login</h1>
        <?php if ($error): ?>
            <p style="color: #ef4444; margin-bottom: 1rem; text-align: center;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="account">Account Name</label>
                <input type="text" id="account" name="account" required placeholder="Enter account name">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter password">
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
