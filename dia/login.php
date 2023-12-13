<?php
include('db_conn.php');

session_start();
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $select  = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['admin_name'] = $row['name'];

        if ($row['user_type'] == 'admin') {
            header('location: admin.html');
        } else {
            header('location: student.php');
        }
    } else {
        $error[] = 'Incorrect email or password';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <style>
        .form-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            padding-bottom: 60px;
            background: #eee;
        }

        .form-container form {
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 1);
            background: #fff;
            text-align: center;
            width: 500px;
        }

        .form-container form h3 {
            font-size: 30px;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #333;
        }

        .form-container form input,
        .form-container form select {
            width: 90%;
            padding: 10px;
            font-size: 15px;
            margin: 8px 0;
            background: #eee;
            border-radius: 5px;
        }

        .form-container form select option {
            background: #fff;
        }

        .form-container form .form-btn {
            background: #fbd0d9;
            color: crimson;
            text-transform: capitalize;
            font-size: 20px;
            cursor: pointer;
        }

        .form-container form .form-btn:hover {
            background: crimson;
            color: #fff;
        }

        .form-container form p {
            margin-top: 10px;
            font-size: 20px;
            color: #333;
        }

        .form-container form a {
            color: crimson;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Login now</h3>

            <input type="email" name="email" required placeholder="E-mail">
            <input type="password" name="password" required placeholder="Password">
            <select name="user_type">
                <option value="student">Student</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="submit" value="Login" class="form-btn">
            <p>don't have an account? <a href="register.php">register</a></p>
        </form>
    </div>
</body>

</html>