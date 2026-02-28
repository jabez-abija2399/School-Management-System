CREATE DATABASE IF NOT EXISTS school;
USE school;

-- 1. Programs Table (Parent)
CREATE TABLE IF NOT EXISTS Programs_table (
    Prog_ID INT AUTO_INCREMENT PRIMARY KEY,
    Prog_Name VARCHAR(100) NOT NULL UNIQUE
);

-- 2. Departments Table (Child of Programs)
CREATE TABLE IF NOT EXISTS Departments_table (
    Dept_ID INT AUTO_INCREMENT PRIMARY KEY,
    Dept_Name VARCHAR(100) NOT NULL,
    Prog_ID INT,
    FOREIGN KEY (Prog_ID) REFERENCES Programs_table(Prog_ID) ON DELETE CASCADE
);

-- 3. Room Table
CREATE TABLE IF NOT EXISTS Room_table (
    Room_ID VARCHAR(10) PRIMARY KEY,
    Bld_num VARCHAR(10) NOT NULL,
    Room_type VARCHAR(50)
);

-- 4. Teacher Table
CREATE TABLE IF NOT EXISTS Teach_table (
    T_Id VARCHAR(10) PRIMARY KEY,
    T_name VARCHAR(100) NOT NULL,
    Major VARCHAR(100)
);

-- 5. Course Table (Child of Departments)
CREATE TABLE IF NOT EXISTS Course_table (
    Co_ID VARCHAR(10) PRIMARY KEY,
    Co_name VARCHAR(100) NOT NULL,
    Dept_ID INT,
    FOREIGN KEY (Dept_ID) REFERENCES Departments_table(Dept_ID) ON DELETE CASCADE
);

-- 6. Student Table
CREATE TABLE IF NOT EXISTS Stud_table (
    Stud_ID VARCHAR(30) PRIMARY KEY,
    Stud_name VARCHAR(100) NOT NULL,
    Age INT,
    Sex CHAR(1),
    Program VARCHAR(50),
    Department VARCHAR(50)
);

-- 7. Login Table
CREATE TABLE IF NOT EXISTS Login_table (
    Account VARCHAR(50) PRIMARY KEY,
    Password VARCHAR(50) NOT NULL
);

-- Seed Initial Data
INSERT IGNORE INTO Programs_table (Prog_Name) VALUES 
('TVET'), ('Bachelor'), ('Postgrad');

INSERT IGNORE INTO Departments_table (Dept_Name, Prog_ID) VALUES 
('Hardware', 1), ('Software', 1),
('Computer Science', 2), ('Information Technology', 2), ('Software Engineering', 2),
('Masters in IT', 3), ('MBA', 3);

INSERT IGNORE INTO Teach_table (T_Id, T_name, Major) VALUES
('T001', 'Kemal', 'Mathematics'),
('T002', 'Ujulu', 'IT'),
('T003', 'Hassen', 'Physics'),
('T004', 'Bikila', 'English');

INSERT IGNORE INTO Course_table (Co_ID, Co_name, Dept_ID) VALUES
('c001', 'Algebra', 4),
('c002', 'Database', 4),
('c003', 'Geophysics', 3),
('c004', 'Spoken English', 3);

INSERT IGNORE INTO Room_table (Room_ID, Bld_num, Room_type) VALUES
('Ro2', 'B001', 'lab'),
('Ro4', 'B002', 'lecture'),
('Ro5', 'B001', 'lab'),
('Ro3', 'B003', 'lecture');

INSERT IGNORE INTO Stud_table (Stud_ID, Stud_name, Age, Sex, Program, Department) VALUES
('TVET-HW-24-001', 'Alemu', 20, 'M', 'TVET', 'Hardware'),
('BAC-CS-24-001', 'Megersa', 23, 'M', 'Bachelor', 'Computer Science'),
('BAC-IT-24-001', 'Kebede', 30, 'M', 'Bachelor', 'Information Technology'),
('PGR-IT-24-001', 'Helen', 23, 'F', 'Postgrad', 'Masters in IT');

INSERT IGNORE INTO Login_table (Account, Password) VALUES ('Account1', '12345'), ('Account2', '54321');
