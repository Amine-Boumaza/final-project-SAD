<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>

<body>
    <h2>Edit Student</h2>

    <?php
    include '../db_conn.php'; // Include your database connection

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editStudent"])) {
        $code = mysqli_real_escape_string($conn, $_POST["code"]);

        // Fetch the student's information based on the code
        $fetchStudentSQL = "SELECT * FROM Students WHERE Code = '$code'";
        $result = $conn->query($fetchStudentSQL);

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();

            // Fetch high school branches from HighSchoolModules table
            $moduleQuery = "SELECT DISTINCT HighSchoolBranch FROM HighSchoolModules";
            $moduleResult = $conn->query($moduleQuery);

            // Display the form with the current student information
    ?>
            <form method="post" action="">
                <input type="hidden" name="code" value="<?= $student['Code'] ?>">

                <label for="selectedModule">High School Branch:</label>
                <select name="selectedModule" required>
                    <?php
                    while ($row = $moduleResult->fetch_assoc()) {
                        $selected = ($row['HighSchoolBranch'] == $student['HighSchoolBranch']) ? "selected" : "";
                        echo "<option value='" . $row['HighSchoolBranch'] . "' $selected>" . $row['HighSchoolBranch'] . "</option>";
                    }
                    ?>
                </select><br>

                <label for="bacNote">BacNote:</label>
                <input type="text" name="bacNote" value="<?= $student['BacNote'] ?>" required><br>

                <label for="name">Name:</label>
                <input type="text" name="name" value="<?= $student['Name'] ?>" required><br>

                <label for="address">Address:</label>
                <input type="text" name="address" value="<?= $student['Address'] ?>" required><br>

                <label for="studentCode">Code:</label>
                <input type="text" name="studentCode" value="<?= $student['Code'] ?>" required><br>

                <label for="studentPassword">Password:</label>
                <input type="password" name="studentPassword" placeholder="Enter new password"><br>

                <!-- Add other fields as needed -->

                <button type="submit" name="updateStudent">Update Student</button>
            </form>
    <?php
        } else {
            echo "Student not found.";
        }
    }

    // Check if the form to update student is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateStudent"])) {
        // Retrieve the form data
        $code = mysqli_real_escape_string($conn, $_POST["code"]);
        $selectedModule = empty($_POST["selectedModule"]) ? "" : mysqli_real_escape_string($conn, $_POST["selectedModule"]);
        $bacNote = empty($_POST["bacNote"]) ? "" : mysqli_real_escape_string($conn, $_POST["bacNote"]);
        $name = empty($_POST["name"]) ? "" : mysqli_real_escape_string($conn, $_POST["name"]);
        $address = empty($_POST["address"]) ? "" : mysqli_real_escape_string($conn, $_POST["address"]);
        $newCode = empty($_POST["studentCode"]) ? "" : mysqli_real_escape_string($conn, $_POST["studentCode"]);
        $newPassword = empty($_POST["studentPassword"]) ? "" : password_hash($_POST["studentPassword"], PASSWORD_DEFAULT);

        // Update the student's information in the database
        $updateStudentSQL = "UPDATE Students SET ";

        // Update each field only if it's not empty
        if (!empty($selectedModule)) {
            $updateStudentSQL .= "HighSchoolBranch='$selectedModule', ";
        }

        if (!empty($bacNote)) {
            $updateStudentSQL .= "BacNote='$bacNote', ";
        }

        if (!empty($name)) {
            $updateStudentSQL .= "Name='$name', ";
        }

        if (!empty($address)) {
            $updateStudentSQL .= "Address='$address', ";
        }

        if (!empty($newCode)) {
            $updateStudentSQL .= "Code='$newCode', ";
        }

        if (!empty($newPassword)) {
            $updateStudentSQL .= "StudentPassword='$newPassword', ";
        }

        // Remove the trailing comma
        $updateStudentSQL = rtrim($updateStudentSQL, ', ');

        // Add the WHERE clause
        $updateStudentSQL .= " WHERE Code='$code'";

        // Execute the SQL query
        if ($conn->query($updateStudentSQL) === TRUE) {
            echo "Student updated successfully";
            header("Location: manageStudents.php");
        } else {
            echo "Error updating student: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
    ?>
</body>

</html>