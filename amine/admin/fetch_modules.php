<?php
// Include your necessary PHP files here
include '../db_conn.php';  // Assuming db_conn.php includes the database connection

// Check if the query parameter is set
if (isset($_POST['query'])) {
    $query = $_POST['query'];

    // Execute the query and fetch modules
    $result = $conn->query($query);
    $modules = [];

    while ($row = $result->fetch_assoc()) {
        $modules[] = $row;
    }

    // Return modules as JSON
    echo json_encode($modules);
} else {
    // If the query parameter is not set, return an empty array
    echo json_encode([]);
}

// Close the database connection
$conn->close();
