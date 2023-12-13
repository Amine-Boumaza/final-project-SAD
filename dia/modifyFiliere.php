<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserer Filiere</title>
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
    if (isset($_POST['modify_f'])) {
        $nom_filiere = $_GET['Nom_Filiere'];
        $modify = mysqli_query($config, "SELECT * FROM filiere WHERE Nom_Filiere=$nom_filiere");
        $data = mysqli_fetch_array($modify);
    }
    ?>
    <a href="index.html">Gestions</a>
    <form action="insert.php" method="post">

        <label for="Nom_Filiere	">Filiere:</label>
        <input type="text" name="Nom_Filiere" required>

        <label for="Nb_place">Number of places:</label>
        <input type="text" name="Nb_place" required>

        <label for="University">University:</label>
        <input type="text" name="University" required>


        <button name='update' type='submit'>Confirm</button>
    </form>

    <a href="listeFiliere.php">la liste des filiere</a>


</body>


</html>