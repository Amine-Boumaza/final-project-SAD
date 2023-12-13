<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Inserer Notes</title>
</head>

<body>
    <a href="index.html">Gestions</a>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'sad');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT Student.Matricule, Student.FirstName, Student.LastName,Student.Moyenne, Module.Nom_module
        FROM Student
        LEFT JOIN note ON Student.Matricule = note.Matricule
        LEFT JOIN Module ON note.ModuleID = Module.ModuleID";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {

        echo "<table>";
        echo "<tr><th>Module</th><th>note</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["Nom_module"] . "</td>";
            echo "<td> <input type='text' name='note'> </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<div class='no-modules'>No modules found for students</div>";
    }

    mysqli_close($conn);
    ?>

</body>

</html>