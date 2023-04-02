<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    if(!isset ($_GET["matricule"])) die("Matricule Absent");
    if(!isset ($_GET["mdp"])) die("Mot de passe absent");
    
    $matricule = $_GET["matricule"];
    $mdp = $_GET["mdp"];
    
    $req = "SELECT profid,profnom,profprenom FROM professeur WHERE profid = :matr AND profmdp = :mdp";
    $stmt = $pdo->prepare($req);
    $stmt->bindParam(":matr",$matricule,PDO::PARAM_STR);
    $stmt->bindParam(":mdp",$mdp,PDO::PARAM_STR);
    $stmt->execute();
    
    
    if($stmt->rowCount() > 0){
        
        $stmt->bindColumn('profnom',$nom);
        $stmt->bindColumn('profprenom',$prenom);
        $stmt->bindColumn('profid',$id);
        $stmt->fetch();
        
        session_start();
        $_SESSION['nom']=$nom;
        $_SESSION['prenom']=$prenom;
        $_SESSION['id']=$id;
        $_SESSION['loggedin']=TRUE;
        $_SESSION['estprof']=TRUE;
        
        
        //echo("Bienvenue ".$prenom.' '.$nom);
        header("location:index.php");
    }else {
        session_start();
        $_SESSION['ERREUR']="<div class=\"error\"> ERREUR: MOT DE PASSE OU UTILISATEUR INCORECT</div>";
        header('location:authprof.php');
    }
}catch(Exception $e){
    die("[{\"nom\":"."chié dans la soupe : ".$e->getMessage()."}]");
}
?>