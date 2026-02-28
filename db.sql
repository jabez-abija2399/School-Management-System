CREATE DATABASE IF NOT EXISTS school;
USE school;

-- Student Table
CREATE TABLE IF NOT EXISTS Stud_table (
    Stud_ID VARCHAR(10) PRIMARY KEY,
    Stud_name VARCHAR(100) NOT NULL,
    Age INT,
    Sex CHAR(1),
    Year INT
);

-- Teacher Table
CREATE TABLE IF NOT EXISTS Teach_table (
    T_Id VARCHAR(10) PRIMARY KEY,
    T_name VARCHAR(100) NOT NULL,
    Major VARCHAR(100)
);

-- Course Table
CREATE TABLE IF NOT EXISTS Course_table (
    Co_ID VARCHAR(10) PRIMARY KEY,
    Co_name VARCHAR(100) NOT NULL,
    department VARCHAR(100)
);

-- Room Table
CREATE TABLE IF NOT EXISTS Room_table (
    Room_ID VARCHAR(10) PRIMARY KEY,
    Bld_num VARCHAR(10) NOT NULL,
    Room_type VARCHAR(50)
);

-- Login Table
CREATE TABLE IF NOT EXISTS Login_table (
    Account VARCHAR(50) PRIMARY KEY,
    Password VARCHAR(50) NOT NULL
);

-- Insert Initial Data (Task 3)
INSERT IGNORE INTO Stud_table (Stud_ID, Stud_name, Age, Sex, Year) VALUES
('S001', 'Alemu', 20, 'M', 2),
('S002', 'Megersa', 23, 'M', 3),
('S003', 'Kebede', 30, 'M', 3),
('S004', 'Helen', 23, 'F', 4);

INSERT IGNORE INTO Teach_table (T_Id, T_name, Major) VALUES
('T001', 'Kemal', 'Mathematics'),
('T002', 'Ujulu', 'IT'),
('T003', 'Hassen', 'Physics'),
('T004', 'Bikila', 'English');

INSERT IGNORE INTO Course_table (Co_ID, Co_name, department) VALUES
('c001', 'Algebra', 'Mathematics'),
('c002', 'Database', 'IT'),
('c003', 'Geophysics', 'Physics'),
('c004', 'Spoken English', 'English');

INSERT IGNORE INTO Room_table (Room_ID, Bld_num, Room_type) VALUES
('Ro2', 'B001', 'lab'),
('Ro4', 'B002', 'lecture'),
('Ro5', 'B001', 'lab'),
('Ro3', 'B003', 'lecture');

INSERT IGNORE INTO Login_table (Account, Password) VALUES
('Account1', '12345'),
('Account2', '54321');
