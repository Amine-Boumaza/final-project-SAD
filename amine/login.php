<?php
session_start();

// Include the authentication logic
include 'authentication.php';

// Create connection
include 'db_conn.php';

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $userType = authenticateUser($conn, $username, $password);

    if ($userType) {
        $_SESSION["username"] = $username;
        $_SESSION["userType"] = $userType;

        // Redirect to the appropriate portal
        if ($userType['userType'] == 'Admin') {
            header("Location: admin/adminportal.html");
        } elseif ($userType['userType'] == 'Student') {
            header("Location: studentportal.php");
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    <h2>Login</h2>
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>

</html>