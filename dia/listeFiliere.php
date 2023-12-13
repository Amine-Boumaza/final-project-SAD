<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Liste Filiere</title>
</head>

<body>
    <a href="index.html">Gestions</a>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'sad');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST['delete'])) {
        $filiereToDelete = $_POST["filiereToDelete"];

        $delete = "DELETE FROM filiere WHERE Nom_Filiere = '$filiereToDelete'";
        $res = mysqli_query($conn, $delete);
    }

    $sql = "SELECT * FROM filiere";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>filiere</th><th>University</th><th>Action</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["Nom_Filiere"] . "</td>";
            echo "<td>" . $row["University"] . "</td>";
            echo "<td class='action-buttons'>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='filiereToDelete' value='" . $row['Nom_Filiere'] . "'>";
            echo "<button type='submit' class='delete-button' name='delete'>Delete</button>";
            echo "</form>";
            echo "<input type='hidden' name='filiereTomodify' value='" . $row['Nom_Filiere'] . "'>";
            echo "<button type='submit' class='modify-button' name='modify'><a href='modifyFiliere.php'>modify</a></button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<div class='no-filiere'>No filieres found</div>";
    }

    mysqli_close($conn);
    ?>

    <button type='submit' class='add-button'><a href="insererfiliere.php">add filiere</a></button>

</body>

</html>