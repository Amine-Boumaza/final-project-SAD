<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
</head>

<body>
    <h2>Manage Students</h2>

    <!-- Add New Student Div -->
    <div>
        <!-- Add New Student Form -->

        <?php
        // Include your necessary PHP files here
        include '../db_conn.php';  // Assuming db_conn.php includes the database connection

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addStudent"])) {
            // Retrieve form data
            $code = mysqli_real_escape_string($conn, $_POST["code"]);
            $selectedModule = mysqli_real_escape_string($conn, $_POST["selectedModule"]);
            $bacNote = mysqli_real_escape_string($conn, $_POST["bacNote"]);
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
            $address = mysqli_real_escape_string($conn, $_POST["address"]);
            $studentPassword = password_hash($_POST["studentPassword"], PASSWORD_DEFAULT);

            // Insert the new student into the Students table
            $insertStudentSQL = "INSERT INTO Students (Code, HighSchoolBranch, BacNote, Name, Address, StudentPassword) 
                                 VALUES ('$code', '$selectedModule', '$bacNote', '$name', '$address', '$studentPassword')";

            if ($conn->query($insertStudentSQL) === TRUE) {
                $successMessage = "New student added successfully";
            } else {
                $errorMessage = "Error: " . $insertStudentSQL . "<br>" . $conn->error;
            }
        }
        ?>

        <!-- Form to add a new student -->
        <form method="post" action="">
            <!-- Your Form Fields -->
            <label for="code">Code:</label>
            <input type="text" name="code" required><br>

            <label for="selectedModule">High School Branch:</label>
            <select name="selectedModule" required>
                <?php
                // Fetch high school branches from HighSchoolModules table
                $moduleQuery = "SELECT DISTINCT HighSchoolBranch FROM HighSchoolModules";
                $moduleResult = $conn->query($moduleQuery);

                while ($row = $moduleResult->fetch_assoc()) {
                    echo "<option value='" . $row['HighSchoolBranch'] . "'>" . $row['HighSchoolBranch'] . "</option>";
                }
                ?>
            </select><br>

            <label for="bacNote">BacNote:</label>
            <input type="text" name="bacNote" required><br>

            <label for="name">Name:</label>
            <input type="text" name="name" required><br>

            <label for="address">Address:</label>
            <input type="text" name="address" required><br>

            <label for="studentPassword">Password:</label>
            <input type="password" name="studentPassword" required><br>

            <button type="submit" name="addStudent">Add Student</button>
        </form>

        <?php
        // Display success or error messages from the PHP code
        if (isset($successMessage)) {
            echo "<p style='color: green;'>$successMessage</p>";
        } elseif (isset($errorMessage)) {
            echo "<p style='color: red;'>$errorMessage</p>";
        }
        ?>
    </div>

    <!-- Student List Div -->
    <div>
        <h3>Student List</h3>

        <?php
        // Fetch all students from the Students table
        $studentListQuery = "SELECT * FROM Students";
        $studentListResult = $conn->query($studentListQuery);

        if ($studentListResult->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Code</th><th>Name</th><th>High School Branch</th><th>BacNote</th><th>Address</th><th>Actions</th></tr>";
            while ($student = $studentListResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$student['Code']}</td>";
                echo "<td>{$student['Name']}</td>";
                echo "<td>{$student['HighSchoolBranch']}</td>";
                echo "<td>{$student['BacNote']}</td>";
                echo "<td>{$student['Address']}</td>";

                echo "<td>";
                // Form to submit for editing
                echo "<form method='post' action='edit_student.php'>";
                echo "<input type='hidden' name='code' value='{$student['Code']}'>";
                echo "<button type='submit' name='editStudent'>Edit</button>";
                echo "</form>";
                // Form to submit for deletion
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='code' value='{$student['Code']}'>";
                echo "<button type='submit' name='deleteStudent'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No students found.";
        }
        ?>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>

</html>