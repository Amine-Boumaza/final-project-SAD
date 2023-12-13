<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Liste Student</title>
</head>

<body>
    <a href="index.html">Gestions</a>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'sad');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST['delete'])) {
        $matriculeToDelete = $_POST["matriculeToDelete"];

        $delete = "DELETE FROM student WHERE Matricule = '$matriculeToDelete'";
        $res = mysqli_query($conn, $delete);
    }

    $sql = "SELECT * FROM student";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Matricule</th><th>First Name</th><th>Last Name</th><th>Speciality</th><th>Moyenne</th><th>Action</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["Matricule"] . "</td>";
            echo "<td>" . $row["FirstName"] . "</td>";
            echo "<td>" . $row["LastName"] . "</td>";
            echo "<td>" . $row["Nom_speciality"] . "</td>";
            echo "<td>" . $row["Moyenne"] . "</td>";
            echo "<td class='action-buttons'>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='matriculeToDelete' value='" . $row['Matricule'] . "'>";
            echo "<button type='submit' class='delete-button' name='delete'>Delete</button>";
            echo "</form>";
            echo "<input type='hidden' name='modify' value='" . $row['Matricule'] . "'>";
            echo "<button type='submit' class='modify-button' name='modify'><a href='modifyEtud.php'>modify</a></button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<div class='no-students'>No students found</div>";
    }

    mysqli_close($conn);
    ?>

    <button type='submit' class='add-button'><a href="insererEtud.php">add student</a></button>

</body>

</html>