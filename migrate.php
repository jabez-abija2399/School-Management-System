<?php
require_once 'config/db.php';

$sql = "
-- Programs Table
CREATE TABLE IF NOT EXISTS Programs_table (
    Prog_ID INT AUTO_INCREMENT PRIMARY KEY,
    Prog_Name VARCHAR(100) NOT NULL UNIQUE
);

-- Departments Table
CREATE TABLE IF NOT EXISTS Departments_table (
    Dept_ID INT AUTO_INCREMENT PRIMARY KEY,
    Dept_Name VARCHAR(100) NOT NULL,
    Prog_ID INT,
    FOREIGN KEY (Prog_ID) REFERENCES Programs_table(Prog_ID) ON DELETE CASCADE
);

-- Seed Programs
INSERT IGNORE INTO Programs_table (Prog_Name) VALUES 
('TVET'), ('Bachelor'), ('Postgrad');

-- Seed Departments
INSERT IGNORE INTO Departments_table (Dept_Name, Prog_ID) VALUES 
('Hardware', 1), ('Software', 1),
('Computer Science', 2), ('Information Technology', 2), ('Software Engineering', 2),
('Masters in IT', 3), ('MBA', 3);

-- Modernize Student Table
ALTER TABLE Stud_table MODIFY Stud_ID VARCHAR(30);
ALTER TABLE Stud_table DROP COLUMN IF EXISTS Year;
ALTER TABLE Stud_table ADD COLUMN IF NOT EXISTS Program VARCHAR(50);
ALTER TABLE Stud_table ADD COLUMN IF NOT EXISTS Department VARCHAR(50);
";

try {
    $pdo->exec($sql);
    echo "Migration successful!";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
?>
