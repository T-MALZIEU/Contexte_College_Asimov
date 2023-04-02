<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table.css">
    <title>Document</title>
</head>
<body>

<div>Ajouter des notes :</div>
<?php

session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('location:authmenu.php');
    exit;
}

if ($_SESSION['estprof']==FALSE) {
    header('location:index.php');
    exit;
}

// Connect to database using PDO
$db = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// Prepare query to retrieve data
$query = $db->prepare('SELECT eleid,elenom,eleprenom FROM eleve ORDER BY elenom');

// Execute query
$query->execute();

// Retrieve results
$results = $query->fetchAll(PDO::FETCH_ASSOC);
?>



<form action="addnote_service.php" class="auth">


<?php
// Build dropdown list with retrieved data
echo '<select name="eleve">';
foreach ($results as $row) {
    echo '<option value="' . $row['eleid'] . '">' . $row['elenom'].' '.$row['eleprenom'] . '</option>';
}
echo '</select>';


$stmt = $db->prepare('SELECT matintitulé, matiere.matid AS bob FROM matiere, enseigne, professeur WHERE professeur.profid = enseigne.profid AND matiere.matid = enseigne.matid AND professeur.profid = :id');

$stmt->bindParam(":id", $_SESSION['id'], PDO::PARAM_STR);

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build dropdown list with retrieved data
echo '<select name="matiere">';
foreach ($results as $row) {
    echo '<option value="' . $row['bob'] . '">' . $row['matintitulé'] . '</option>';
}
echo '</select>';



?>
<input type="text" id="name" name="nom" required   size="15" placeholder="Intitulé">
<input type="number" id="name" name="note" required  maxlength="3" size="10" placeholder="Note SUR 100">
<br><button class="button">Ajouter</button>
</form>


</br>
<a href="index.php">Retour au menu</a>
</body>
</html>