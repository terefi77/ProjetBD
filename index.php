<?php  require('entete.php'); ?>
<?php  require('connect.php'); ?>
<?php 
    session_start();
     if (empty($_SESSION['email']))
    {
      $_SESSION['message']="Vous n'avez pas le droit d'accéder à cette page";
      // on redirige vers login
      header("Location:login.php");
    }
    //sinon on stocke l'utilisateur courant dans la variable $pesudo
    else
    {
      $email= $_SESSION['email'];
    }
    //Connexion à la base
    $connexion=mysqli_connect("p:".SERVEUR, NOM, PASSE,BD);
    if (!$connexion)
    {
      echo "<p>Problème : Connexion au serveur ".SERVEUR." ou à la base ".BD." impossible. <br> Erreur : ".mysqli_error()."</p>";
    }
$sql_user="SELECT nomU, prenomU, poste FROM Utilisateur WHERE email='$email'";
$res_user=mysqli_query($connexion, $sql_user);
$user=mysqli_fetch_assoc($res_user);
$nom=$user['nomU'];
$prenom=$user['prenomU'];
$poste=$user['poste'];
?>
<div class="container mt-5">
    <div class="text-center">
        <h1 class="mb-4">Bienvenue, <?php echo htmlspecialchars($prenom . " " . $nom); ?> !</h1>
        <p class="d-flex align-items-start justify-content-start">Poste : <strong><?php echo htmlspecialchars($poste); ?></strong></p>
        <p>Vous pouvez gérer les patients, surveiller les alertes, et affecter les chambres selon votre responsabilité.</p>
    </div>
</div>
<?php  require('footer.php'); ?>