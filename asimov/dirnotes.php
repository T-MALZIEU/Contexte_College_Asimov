<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('location:authmenu.php');
    exit;
}

if ($_SESSION['estprof']==FALSE) {
    header('location:index.php');
    exit;
}

if(!isset($_SESSION['dir']) || $_SESSION['dir']==FALSE){
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
$_SESSION['LAST_ACTIVITY'] = time(); 









// Connect to database using PDO
$host = 'localhost';
$dbname = 'asimov';
$username = 'root';
$password = 'root';

$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Get all students and their notes
$sql = "SELECT eleve.eleNom, eleve.elePrenom, note.notId, note.notNote, note.notIntitulé, matiere.matIntitulé
        FROM eleve 
        INNER JOIN note ON eleve.eleId = note.eleId 
        INNER JOIN matiere ON note.matId = matiere.matId
        ORDER BY eleve.elenom";

$stmt = $db->prepare($sql);
$stmt->execute();
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['delete'])) {
    // Delete note
    $note_id = $_POST['delete'];
    $sql = "DELETE FROM note WHERE notId = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$note_id]);
  } elseif (isset($_POST['edit'])) {
    // Edit note
    $note_id = $_POST['edit'];
    $new_note = $_POST['new_note'];
    $sql = "UPDATE note SET notNote = ? WHERE notId = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$new_note, $note_id]);
  }
  
  // Redirect to same page to avoid form resubmission on refresh
  header("Location: {$_SERVER['REQUEST_URI']}");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Directeur-NOTES</title>
</head>
<body>
  <h1>Notes de touts les étudiants</h1>
  
  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Matière</th>
        <th>Intitulé</th>
        <th>Note</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($notes as $note): ?>
        <tr>
          <td><?php echo $note['eleNom'] . ' ' . $note['elePrenom']; ?></td>
          <td><?php echo $note['matIntitulé']; ?></td>
          <td><?php echo $note['notNote']; ?></td>
          <td><?php echo $note['notIntitulé']; ?></td>
          <td>
            <form method="post">
              <input type="hidden" name="delete" value="<?php echo $note['notId']; ?>">
              <button type="submit">Delete</button>
            </form>
            <form method="post">
              <input type="hidden" name="edit" value="<?php echo $note['notId']; ?>">
              <input type="text" name="new_note" value="<?php echo $note['notNote']; ?>">
              <button type="submit">Edit</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>


  <a href="index.php">Retour au menu</a>
</body>
</html>
