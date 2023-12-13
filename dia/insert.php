<?php
$conn = mysqli_connect('localhost', 'root', '', 'sad');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['ajouter'])) {
    $matricule = $_POST["matricule"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $moyenne = $_POST["moyenne"];
    $nom_speciality = $_POST["nom_speciality"];

    $sql = "INSERT INTO student (Matricule, FirstName, LastName, Moyenne, Nom_speciality )
     VALUES ('$matricule', '$firstName', '$lastName', '$moyenne', '$nom_speciality')";


    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Data inserted successfully");</script>';
    } else {
        echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
    }

    header('Location: insererEtud.php');
}




mysqli_close($conn);
?>


<?php
$conn = mysqli_connect('localhost', 'root', '', 'sad');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['ajouter_f'])) {
    $Nom_Filiere = $_POST["Nom_Filiere"];
    $Nb_place = $_POST["Nb_place"];
    $University = $_POST["University"];


    $sql = "INSERT INTO filiere (Nom_Filiere, Nb_place, University)
     VALUES ('$Nom_Filiere', '$Nb_place', '$University')";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Data inserted successfully");</script>';
    } else {
        echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
    }

    header('Location: insererfiliere.php');
}




mysqli_close($conn);
?>

