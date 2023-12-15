<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Grades</title>
</head>

<body>
    <h2>Manage Grades</h2>

    <?php
    // Include your necessary PHP files here
    include '../db_conn.php';  // Assuming db_conn.php includes the database connection

    // Check if the form is submitted to choose a student
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["chooseStudent"])) {
        // Retrieve form data
        $selectedStudentID = mysqli_real_escape_string($conn, $_POST["selectedStudent"]);

        // Fetch the selected student's details
        $studentDetailsQuery = "SELECT * FROM Students WHERE StudentID = '$selectedStudentID'";
        $studentDetailsResult = $conn->query($studentDetailsQuery);

        if ($studentDetailsResult->num_rows > 0) {
            $student = $studentDetailsResult->fetch_assoc();

            // Fetch modules related to the selected student's branch
            $modulesQuery = "SELECT ModuleName FROM HighSchoolModules WHERE HighSchoolBranch = '{$student['HighSchoolBranch']}'";
            $modulesResult = $conn->query($modulesQuery);

            // Display the form to add grades for the selected student
            echo "<h3>Student Details</h3>";
            echo "<p><strong>Code:</strong> {$student['Code']}</p>";
            echo "<p><strong>Name:</strong> {$student['Name']}</p>";
            echo "<p><strong>High School Branch:</strong> {$student['HighSchoolBranch']}</p>";

            // Form to add grades
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='selectedStudentID' value='$selectedStudentID'>";
            echo "<table border='1'>";
            echo "<tr><th>Module Name</th><th>Grade</th></tr>";

            // Display branch name for each module
            $modulesResult->data_seek(0); // Reset pointer to the beginning
            while ($module = $modulesResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$module['ModuleName']}</td>";
                echo "<td><input type='text' name='grades[{$module['ModuleName']}]'></td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<button type='submit' name='addGrades'>Add Grades</button>";
            echo "</form>";
        } else {
            echo "Student not found.";
        }
    }

    // Process the submitted grades
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addGrades"])) {
        $selectedStudentID = mysqli_real_escape_string($conn, $_POST["selectedStudentID"]);
        $grades = $_POST["grades"];

        // Retrieve student details again
        $studentDetailsQuery = "SELECT * FROM Students WHERE StudentID = '$selectedStudentID'";
        $studentDetailsResult = $conn->query($studentDetailsQuery);

        if ($studentDetailsResult->num_rows > 0) {
            $student = $studentDetailsResult->fetch_assoc();

            // Process the grades and insert into the HighSchoolGrades table
            foreach ($grades as $module => $grade) {
                $insertGradeSQL = "INSERT INTO HighSchoolGrades (StudentCode, StudentName, HighSchoolBranch, ModuleName, Grade) 
                                   VALUES ('{$student['Code']}', '{$student['Name']}', '{$student['HighSchoolBranch']}', '$module', '$grade')";

                if ($conn->query($insertGradeSQL) !== TRUE) {
                    echo "Error inserting grades: " . $conn->error;
                }
            }

            echo "Grades added successfully!";
        } else {
            echo "Student not found.";
        }
    }
    ?>

    <!-- Form to choose a student -->
    <form method="post" action="">
        <label for="selectedStudent">Choose a Student:</label>
        <select name="selectedStudent" required>
            <?php
            // Fetch all students for the dropdown
            $studentsQuery = "SELECT * FROM Students";
            $studentsResult = $conn->query($studentsQuery);

            while ($row = $studentsResult->fetch_assoc()) {
                echo "<option value='" . $row['StudentID'] . "'>" . $row['Name'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="chooseStudent">Choose Student</button>
    </form>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>

</html>