<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>ASIMOV: Identification</title>
</head>
<body>
<?php 
session_start();
if (isset($_SESSION['ERREUR'])) {
    
    $error = $_SESSION['ERREUR']; 
    echo $error;
    
    
}
session_destroy();?>
<a href="authprof.php">S'identifier en tant que Professeur</a>
<br>
<a href="autheleve.php">S'identifier en tant qu'Eleve</a>
</body>
</html>


