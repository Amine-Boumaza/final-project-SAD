
<?php
include('config.php');

if (isset($_POST['update'])) {
    $Matricule = $_POST['Matricule'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Moyenne = $_POST['Moyenne'];
    $Nom_speciality = $_POST['Nom_speciality'];

    $update = "UPDATE student Set FirstName='$FirstName', LastName='$LastName', Moyenne='$Moyenne', Nom_speciality=' $Nom_speciality'  WHERE Matricule=$Matricule";
    mysqli_query($config, $update);

    header('location: listeEtud.php');
}
?>
