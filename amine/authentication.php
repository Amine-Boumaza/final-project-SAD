<?php

// Include your necessary PHP files here
include 'db_conn.php';  // Assuming db_config.php includes the database connection

// Function to validate login credentials
function authenticateUser($conn, $username, $password)
{
    // Sanitize inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);

    // Check if the username is associated with a student
    $studentQuery = "SELECT UserID, StudentPassword FROM Students WHERE Code = '$username'";
    $studentResult = $conn->query($studentQuery);

    if ($studentResult->num_rows > 0) {
        $studentRow = $studentResult->fetch_assoc();
        $hashedPassword = $studentRow['StudentPassword'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, return the student ID and type
            return array('userType' => 'Student', 'userID' => $studentRow['UserID']);
        }
    }

    // Check if the username is associated with an admin
    $adminQuery = "SELECT UserID, Password FROM Users WHERE Username = '$username' AND UserType = 'Admin'";
    $adminResult = $conn->query($adminQuery);

    if ($adminResult->num_rows > 0) {
        $adminRow = $adminResult->fetch_assoc();
        $hashedPassword = $adminRow['Password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, return the admin ID and type
            return array('userType' => 'Admin', 'userID' => $adminRow['UserID']);
        }
    }

    // Authentication failed
    return false;
}
