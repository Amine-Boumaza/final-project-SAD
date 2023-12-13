<?php
session_start();
include '../db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password (you should use password_hash in a real-world scenario)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into Users table
    $sqlInsertUser = "INSERT INTO Users (Username, Password, UserType) VALUES ('$username', '$hashedPassword', 'Admin')";
    $conn->query($sqlInsertUser);

    $userID = $conn->insert_id;

    // Insert into Admins table
    $sqlInsertAdmin = "INSERT INTO Admins (UserID) VALUES ($userID)";
    $conn->query($sqlInsertAdmin);

    // Set session variables for admin
    $_SESSION["username"] = $username;
    $_SESSION["userType"] = 'Admin';


    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
</head>

<body>
    <h2>Add Admin</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Add Admin</button>
    </form>
</body>

</html>