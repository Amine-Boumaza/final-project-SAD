<?php
// Include your necessary PHP files here
include '../db_conn.php';  // Assuming db_conn.php includes the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteStudent"])) {
    // Retrieve the student code from the form data
    $codeToDelete = mysqli_real_escape_string($conn, $_POST["code"]);

    // Delete the student from the Students table
    $deleteStudentSQL = "DELETE FROM Students WHERE Code = '$codeToDelete'";

    if ($conn->query($deleteStudentSQL) === TRUE) {
        $successMessage = "Student deleted successfully";
    } else {
        $errorMessage = "Error: " . $deleteStudentSQL . "<br>" . $conn->error;
    }
}

// Redirect back to the main page (you may change the URL accordingly)
header("Location: ../admin/manageStudents.php");
exit();
