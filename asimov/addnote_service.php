<?php
try {
    // Check if required parameters are set
    if(!isset($_GET["eleve"]) || !isset($_GET["matiere"]) || !isset($_GET["note"])|| !isset($_GET["nom"])) {
        die("Il manque des trucs");
    }

    // Get parameters from GET request
    $eleve = $_GET["eleve"];
    $note = $_GET["note"];
    $matiere = $_GET["matiere"];
    $nom = $_GET["nom"];

    // Connect to database using PDO
    $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // Prepare statement to select claid (class id) from eleve table using eleid (student id)
    $stmt2 = $pdo->prepare('SELECT claid FROM eleve WHERE eleid=:eleve');
    $stmt2->bindParam(":eleve", $eleve, PDO::PARAM_INT);
    $stmt2->execute();

    // Fetch the claid using bindColumn and fetch methods
    $stmt2->bindColumn("claid", $classe);
    $stmt2->fetch();

    // Prepare INSERT statement to insert new note into note table
    $req = "INSERT INTO note(notNote, eleid, matid, notIntitulé, claid) VALUES(:note, :eleve, :matiere, :nom, :classe)";
    $stmt = $pdo->prepare($req);
    $stmt->bindParam(":note", $note, PDO::PARAM_INT);
    $stmt->bindParam(":eleve", $eleve, PDO::PARAM_INT);
    $stmt->bindParam(":matiere", $matiere, PDO::PARAM_INT);
    $stmt->bindParam(":classe", $classe, PDO::PARAM_INT);
    $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect to addnote.php after successful insertion
    header("location: addnote.php");

} catch (Exception $e) {
    // Handle any exceptions that occur during execution
    die("Error: " . $e->getMessage());
}

?>