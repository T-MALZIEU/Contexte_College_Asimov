<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ASIMOV-etudiant : Notes</title>
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

if ($_SESSION['estprof']==TRUE) {
    header('location:index.php');
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



?>
    <div class="asimov">Notes de <?=$_SESSION['prenom']?> <?=$_SESSION['nom']?></div>

    <?php
    
    $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $req ="SELECT notintitulé,notnote,matiere.matid AS matid,matintitulé FROM note,matiere WHERE note.matid=matiere.matid AND eleid=:id  ORDER BY matintitulé";
$stmt = $pdo->prepare($req);
$stmt->bindParam(":id",$_SESSION['id'],PDO::PARAM_STR);
$stmt->execute();

$lastMatId = null;
$sum = 0;
$count = 0;
$totalSum = 0;
$totalCount = 0;
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    if ($row['matid'] != $lastMatId) {
        if ($lastMatId !== null) {
            $avg = $sum / $count;
            echo "<tr><td colspan='2'>Moyenne:</td><td>$avg</td></tr>";
            echo "</table>";
        }
        $lastMatId = $row['matid'];
        $matiere = $row['matintitulé'];
        echo "<h3>$matiere</h3>";
        echo "<table class='notes' border='1'><tr><th>INTITULÉ</th><th>NOTE</th><th>MOYENNE</th></tr>";
        $sum = 0;
        $count = 0;
    }
    echo "<tr>";
    echo "<td>" . $row['notintitulé'] . "</td>";
    echo "<td>" . $row['notnote'] . "</td>";
    $sum += $row['notnote'];
    $count++;
    $totalSum += $row['notnote'];
    $totalCount++;
    echo "</tr>";
}
if ($lastMatId !== null) {
    $avg = $sum / $count;
    echo "<tr><td colspan='2'>Moyenne:</td><td>".round($avg, 2)."</td></tr>";
    echo "</table>";
}

if ($totalCount > 0) {
    $totalAvg = $totalSum / $totalCount;
    echo "<h3>Moyenne globale: ".round($totalAvg, 2)."</h3> ";
}
    ?>
    <a href="index.php">Retour au menu</a>



</body>
</html>