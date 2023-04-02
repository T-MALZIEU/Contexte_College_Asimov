<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ASIMOV : Acceuil</title>
<link rel="stylesheet" href="table.css">
</head>
<body>


<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('location:authmenu.php');
    exit;
}

// We need to use sessions, so you should always start sessions using the below code.
// If the user is not logged in redirect to the login page...
if ($_SESSION['estprof']==TRUE) {
    echo "<div class=\"info\"> Vous êtes identifié en tant que professeur.</div>";
}


?>

<div class="intro">
<p>Bienvenue <?=$_SESSION['prenom']?> <?=$_SESSION['nom']?> .</p>
</div>

<?php
if ($_SESSION['estprof']==FALSE) {
   echo "<a href=\"notes.php\">Voir mes notes</a>";
}
if ($_SESSION['estprof']==TRUE) {
   echo "<a href=\"addnote.php\">Ajouter des notes</a>";
}
?>


<form action="logout.php">
<button class="button">Deconexion</button>
</form>


</body>
</html>