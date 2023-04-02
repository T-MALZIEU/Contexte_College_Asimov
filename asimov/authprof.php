<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ASIMOV-professeur : Identification</title>
<link rel="stylesheet" href="table.css">
</head>
<body>

<div class="asimov">Identification en tant que professeur</div>

<?php 
session_start();
if (isset($_SESSION['ERREUR'])) {
    
    $error = $_SESSION['ERREUR']; 
    echo $error;
    
    
}
session_destroy();?>
<br>
<form action="authprof_service.php" class="auth">



<label for="matricule">Entrez votre matricule :</label>
<input type="number" id="name" name="matricule" required  maxlength="8" size="10" placeholder="Matricule">

<br><label for="mdp">Entrez votre mot de passe :</label>
<input type="password" id="name" name="mdp" required   size="10" placeholder="Mot de passe">
<br>
<br><button class="button">S'identifier</button>
</form>

<form action="authmenu.php" class="auth">
<button class="button">Retour</button>
</form>
</body>
</html>