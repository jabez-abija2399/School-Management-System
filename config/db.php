<?php
$host = 'localhost';
$db   = 'school';
$user = 'root'; // Change if needed
$pass = '';     // Change if needed
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // For development, we'll show the error. In production, log it.
     die("Connection failed: " . $e->getMessage());
}
?>
