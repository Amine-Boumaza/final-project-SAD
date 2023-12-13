<?php
include('db_conn.php');

// Assuming you have a connection to the database ($conn)

// Fetch all student records from the Student table
$query = "SELECT * FROM Student";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<ul>";

    while ($row = mysqli_fetch_assoc($result)) {
        $matricule = $row['Matricule'];
        $firstName = $row['FirstName'];
        $lastName = $row['LastName'];

        // Display a link to view the details of each student
        echo "<li><a href='view_student.php?matricule=$matricule'>$firstName $lastName</a></li>";
    }

    echo "</ul>";
} else {
    echo "No student records found.";
}

// Close the database connection
mysqli_close($conn);
