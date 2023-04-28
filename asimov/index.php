<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ASIMOV : Acceuil</title>
<link rel="stylesheet" href="style.css">
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

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    session_start();
        $_SESSION['ERREUR']="<div class=\"error\"> DÉCONEXION AUTOMATIQUE : VOUS ETES RESTÉ INACTIF TROP LONGTEMPS</div>";
    header('location:authmenu.php');
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

// We need to use sessions, so you should always start sessions using the below code.
// If the user is not logged in redirect to the login page...

if(isset($_SESSION['dir']) && $_SESSION['dir']==TRUE){
   echo "<div class=\"info\"> Vous êtes identifié en tant que directeur.</div>";
}
else if ($_SESSION['estprof']==TRUE) {
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

if(isset($_SESSION['dir']) && $_SESSION['dir']==TRUE){
    echo "<br><a href=\"dirnotes.php\">Modifier les notes des élèves</a>";
}
?>


<form action="logout.php">
<button class="button">Deconexion</button>
</form>


</body>
</html>