-- Active: 1680283139327@@127.0.0.1@3306@sadtest
-- Create the Users table (Admins and Students)
-- Create the Users table

CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL, -- Hashed password in a real-world scenario
    UserType ENUM('Admin', 'Student') NOT NULL
);

-- Create the Students table
-- Create the Students table
CREATE TABLE Students (
    StudentID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT UNIQUE,
    Code VARCHAR(5) UNIQUE NOT NULL,
    HighSchoolBranch VARCHAR(50) NOT NULL,
    BacNote FLOAT NOT NULL,
    Name VARCHAR(100) NOT NULL,
    Address VARCHAR(255) NOT NULL,
    StudentPassword VARCHAR(255) NOT NULL,
    INDEX(Code, Name), -- Add this line to create an index on Code and Name
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);




-- Create the Admins table
CREATE TABLE Admins (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT UNIQUE,
    -- Other admin details as needed
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Create the High School Modules table
CREATE TABLE HighSchoolModules (
    ModuleID INT PRIMARY KEY AUTO_INCREMENT,
    HighSchoolBranch VARCHAR(50) NOT NULL,
    ModuleName VARCHAR(50) NOT NULL,
    UNIQUE (HighSchoolBranch, ModuleName)
);

-- Create the High School Grades table
-- Create the High School Grades table
CREATE TABLE HighSchoolGrades (
    GradeID INT PRIMARY KEY AUTO_INCREMENT,
    StudentCode VARCHAR(5) NOT NULL, -- Reference to the student's code
    StudentName VARCHAR(100) NOT NULL, -- Reference to the student's name
    HighSchoolBranch VARCHAR(50) NOT NULL,
    ModuleName VARCHAR(50) NOT NULL,
    Grade DECIMAL(3, 2) NOT NULL,
    FOREIGN KEY (StudentCode, StudentName) REFERENCES Students(Code, Name),
    FOREIGN KEY (HighSchoolBranch, ModuleName) REFERENCES HighSchoolModules(HighSchoolBranch, ModuleName)
);



-- Create the Specializations table
CREATE TABLE Specializations (
    SpecializationID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50) UNIQUE NOT NULL,
    BranchRestriction VARCHAR(50) NOT NULL,
    DeterminingModuleID INT,
    MaxCapacity INT NOT NULL,
    SpecializationGrade DECIMAL(3, 2) NOT NULL,
    FOREIGN KEY (DeterminingModuleID) REFERENCES HighSchoolModules(ModuleID)
);

-- Create the Student Choices table
CREATE TABLE StudentChoices (
    ChoiceID INT PRIMARY KEY AUTO_INCREMENT,
    StudentID INT,
    SpecializationID INT,
    FOREIGN KEY (StudentID) REFERENCES Students(StudentID),
    FOREIGN KEY (SpecializationID) REFERENCES Specializations(SpecializationID)
);

-- Create the Results table
CREATE TABLE Results (
    ResultID INT PRIMARY KEY AUTO_INCREMENT,
    StudentID INT,
    SpecializationID INT,
    Eligible BOOLEAN NOT NULL,
    FOREIGN KEY (StudentID) REFERENCES Students(StudentID),
    FOREIGN KEY (SpecializationID) REFERENCES Specializations(SpecializationID)
);

-- Insert Science branch modules
INSERT INTO HighSchoolModules (HighSchoolBranch, ModuleName) VALUES
('Science', 'Arabic'),
('Science', 'Islamic sciences'),
('Science', 'English language'),
('Science', 'physical education'),
('Science', 'French language'),
('Science', 'Geography'),
('Science', 'history'),
('Science', 'mathematics'),
('Science', 'Physical sciences'),
('Science', 'Philosophy'),
('Science', 'Natural and life sciences');

-- Insert Math branch modules
INSERT INTO HighSchoolModules (HighSchoolBranch, ModuleName) VALUES
('Math', 'Arabic'),
('Math', 'Islamic sciences'),
('Math', 'English language'),
('Math', 'physical education'),
('Math', 'French language'),
('Math', 'Geography'),
('Math', 'history'),
('Math', 'mathematics'),
('Math', 'Physical sciences'),
('Math', 'Philosophy');
-- Insert Math_G branch modules
INSERT INTO HighSchoolModules (HighSchoolBranch, ModuleName) VALUES
('Math_G', 'Arabic'),
('Math_G', 'Islamic sciences'),
('Math_G', 'English language'),
('Math_G', 'physical education'),
('Math_G', 'French language'),
('Math_G', 'Geography'),
('Math_G', 'history'),
('Math_G', 'mathematics'),
('Math_G', 'Physical sciences'),
('Math_G', 'Philosophy'),
('Math_G', 'Civil Engineering');
-- Insert Math_M branch modules
INSERT INTO HighSchoolModules (HighSchoolBranch, ModuleName) VALUES
('Math_M', 'Arabic'),
('Math_M', 'Islamic sciences'),
('Math_M', 'English language'),
('Math_M', 'physical education'),
('Math_M', 'French language'),
('Math_M', 'Geography'),
('Math_M', 'history'),
('Math_M', 'mathematics'),
('Math_M', 'Physical sciences'),
('Math_M', 'Philosophy'),
('Math_M', 'Mechanical Engineering');

-- Insert Math_E branch modules
INSERT INTO HighSchoolModules (HighSchoolBranch, ModuleName) VALUES
('Math_E', 'Arabic'),
('Math_E', 'Islamic sciences'),
('Math_E', 'English language'),
('Math_E', 'physical education'),
('Math_E', 'French language'),
('Math_E', 'Geography'),
('Math_E', 'history'),
('Math_E', 'mathematics'),
('Math_E', 'Physical sciences'),
('Math_E', 'Philosophy'),
('Math_E', 'Electrical Engineering');

-- Insert Math_Ch branch modules
INSERT INTO HighSchoolModules (HighSchoolBranch, ModuleName) VALUES
('Math_Ch', 'Arabic'),
('Math_Ch', 'Islamic sciences'),
('Math_Ch', 'English language'),
('Math_Ch', 'physical education'),
('Math_Ch', 'French language'),
('Math_Ch', 'Geography'),
('Math_Ch', 'history'),
('Math_Ch', 'mathematics'),
('Math_Ch', 'Physical sciences'),
('Math_Ch', 'Philosophy'),
('Math_Ch', 'Chemical Engineering');

-- Insert Lang branch modules
INSERT INTO HighSchoolModules (HighSchoolBranch, ModuleName) VALUES
('Lang', 'Arabic'),
('Lang', 'Islamic sciences'),
('Lang', 'English language'),
('Lang', 'physical education'),
('Lang', 'French language'),
('Lang', 'Geography'),
('Lang', 'history'),
('Lang', 'mathematics'),
('Lang', 'Philosophy'),
('Lang', 'German/Spanish/Italian');

-- Insert Lettre branch modules
INSERT INTO HighSchoolModules (HighSchoolBranch, ModuleName) VALUES
('Lettre', 'Arabic'),
('Lettre', 'Islamic sciences'),
('Lettre', 'English language'),
('Lettre', 'physical education'),
('Lettre', 'French language'),
('Lettre', 'Geography'),
('Lettre', 'History'),
('Lettre', 'mathematics'),
('Lettre', 'Philosophy');

-- Insert Filo branch modules
INSERT INTO HighSchoolModules (HighSchoolBranch, ModuleName) VALUES
('Filo', 'Arabic'),
('Filo', 'Islamic sciences'),
('Filo', 'English language'),
('Filo', 'physical education'),
('Filo', 'French language'),
('Filo', 'Geography'),
('Filo', 'History'),
('Filo', 'mathematics'),
('Filo', 'Philosophy');

ALTER TABLE Students
ADD COLUMN BacNote DECIMAL(3, 2);



SET foreign_key_checks = 0;
TRUNCATE TABLE HighSchoolModules;
SET foreign_key_checks = 1;

drop Table highschoolmodules;

SELECT DISTINCT HighSchoolBranch FROM HighSchoolModules