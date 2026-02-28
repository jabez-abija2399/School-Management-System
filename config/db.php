<?php
$host = 'localhost';
$db   = 'school';
$user = 'root'; 
$pass = '';     
$charset = 'utf8mb4';

//MySQL User Name : if0_41269536  
//  	MySQL Host Name: sql103.infinityfree.com
// $servername = "sql103.infinityfree.com";  // MySQL host from vPanel
// $username   = "if0_41269536";              // MySQL username
// $password   = "2djFJC3y6SKYbCx";         // MySQL password
// $dbname     = "if0_41269536_School";              // Database name

// $conn = new mysqli($servername, $username, $password, $dbname);


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
