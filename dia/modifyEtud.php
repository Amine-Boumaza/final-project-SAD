<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserer Etudiant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <?php
    include('config.php');

    $matricule = isset($_GET['Matricule']) ? $_GET['Matricule'] : '';

    $sql = "SELECT * FROM student WHERE Matricule = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $matricule);

    mysqli_stmt_execute($stmt);

    $modify = mysqli_stmt_get_result($stmt);

    $data = mysqli_fetch_array($modify);

    mysqli_stmt_close($stmt);

    ?>

    <a href="index.html">Gestions</a>

    <form action="update.php" method="post">

        <label for="matricule">Matricule:</label>
        <input type="text" name="Matricule" required>

        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" required>

        <label for="moyenne">Moyenne:</label>
        <input type="text" name="moyenne" required>

        <label for="nom_speciality">Speciality:</label>
        <select name="nom_speciality" required>
            <option value="science">Science</option>
            <option value="maths">Maths</option>
            <option value="literature">Literature</option>
        </select>

        <button name='update' type='submit'>Confirm</button>
    </form>

    <a href="listeEtud.php">la liste des etudiants</a>


</body>


</html>